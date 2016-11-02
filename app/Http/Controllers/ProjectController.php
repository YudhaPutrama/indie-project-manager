<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Auth;
use Config;
use Image;
use Intervention\Image\Exception\NotWritableException;
use Response;
use Validator;
use App\Project;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{

    public function newProject(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'picture'=>'required|image',
            'start'=>'required|date',
            'deadline'=>'required|date|after:start',
        ]);
        if ($validator->passes()){
            $picture = $request['picture'];
            $filename = time().'_'.Auth::user()->id.'.'.$request->file('picture')->getClientOriginalExtension();
            Image::make($picture)->fit(300, 300)->save(public_path(Config::get('image.dir.projects.picture').$filename));

            $project = new Project();
            $project->name = $request->get('name');
            $project->description = $request->get('description');
            $project->picture = $filename;
            $project->start = $request->get('start');
            $project->deadline = $request->get('deadline');
            $project->user_id = Auth::user()->id;

            if ($project->save()){
                return Response::json(['status'=>'success']);
            }

        }
        return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
    }

    public function updateProject(Project $project, Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'picture'=>'image',
            'start'=>'required|date',
            'deadline'=>'required|date|after:start',
        ]);
        if ($validator->passes()){


            $project->name = $request->get('name');
            $project->description = $request->get('description');
            if ($request->hasFile('picture')){
                $picture = $request['picture'];
                $filename = time().'_'.Auth::user()->id.'.'.$request->file('picture')->getClientOriginalExtension();
                Image::make($picture)->fit(300, 300)->save(public_path(Config::get('image.dir.projects.picture').$filename));
                $project->picture = $filename;
            }
            $project->start = $request->get('start');
            $project->deadline = $request->get('deadline');
            $project->user_id = Auth::user()->id;

            if ($project->save()){
                return Response::json(['status'=>'success']);
            }

        }
        return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
    }

    public function listProject(){

        if (Auth::user()->isAdmin()){
            $projects = Project::with('members')->all();
        } else {
            $projects = Auth::user()->projects;
        }
        return view('project-list',$projects);
    }

    public function client(){
        return $this->showProjectDetail(Auth::user()->projects()->first());
    }

    public function showProject(){
        $user = Auth::user();
        if (Auth::user()->isAdmin()){
            $projects = Project::all();
            return view('project-list',['user'=>$user,'projects'=>$projects]);
        } elseif (Auth::user()->isStaff()) {
            $projects = Auth::user()->projects;
            return view('project-list',['user'=>$user,'projects'=>$projects]);
        } else {
            $project = Auth::user()->projects()->first();
            if ($project==null){
                return view('no-project');
            }
            return redirect()->route('project-detail',['project'=>$project]);
            //return view('project-detail',['user'=>$user, 'project'=>$project]);
        }
    }


    public function showProjectDetail(Project $project){
//        if(Auth::user()->isClient()){
//            return redirect('/projects')->with('error',"You does'nt have an access");
//        }
        $this->authorize('view', $project);
        $data = [
            'user' => Auth::user(),
            'project' => $project
        ];
        //return $data;
        return view('project-detail',$data);
    }

    public function showUpload(Project $project){
        return view('fileupload',['project'=>$project]);
    }

    public function uploadPhotos(Request $request, Project $project){
        if ($request->hasFile('file')){
            $validator = Validator::make($request->all(), ['avatar'=>'image']);
            if ($validator->fails()){
                return Response::json(['status'=>'error']);
            }
            $user = Auth::user();
            $file = $request->file('file');
            $filename_full = $project->id.'_'.$user->id.'_'.time().'_full'.'.'.$file->getClientOriginalExtension();
            $filename_icon = $project->id.'_'.$user->id.'_'.time().'_icon'.'.'.$file->getClientOriginalExtension();

            try {
                //save full size
                Image::make($file)->save(public_path(Config::get('image.dir.projects.photos')) . $filename_full);

                //save icon size
                Image::make($file)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path(Config::get('image.dir.projects.photos')) . $filename_icon);
            } catch (NotWritableException $ex){
                return Response::json(['status'=>'error','detail'=>'Error when saving']);
            }
            $photo = new Photo();
            $photo->user_id = Auth::user()->id;
            $photo->title = "Project Photo";
            $photo->url = $filename_full;
            $photo->url_thumb = $filename_icon;
            $photo->status = "uploaded";
            $photo->location = '';


            if ($project->photos()->save($photo)){
                //return $image_full;
                return Response::json(['status'=>'success'],200);
            }
        }
        return Response::json(['status'=>'error']);
    }

    public function listMember(Project $project, Request $request){
        //return $project->members;
        $members = $project->members;
        //$staff = $members->
        return view('member-list', ['members'=>$members]);
    }

    public function addMember(Request $request, Project $project){
        $this->authorize('update', $project);
        if ($request->has('fromId')){
            $user = User::where('username',$request->get('username'))->first();
            if ($user==null){
                return Response::json(['status'=>'error']);
            }

            $project->members()->attach($user->id);

            return Response::json(['status'=>'success']);
        }
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'username'=>'required',
            'password'=>'required'
        ]);
        if ($validator->fails()){
            return Response::json(['status'=>'error','error'=>$validator->errors()->first()]);
        }
        $user = new User();
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        if (!$user->makeClient()){
            return Response::json(['status'=>'error','error'=>'cannot save data']);
        }
        $project->members()->attach($user->id);
        return Response::json(['status'=>'success','user'=>$user]);
    }

    public function removeMember(Project $project, User $user){
        if (!$project->members()->detach($user->id)){
            return redirect()->back()->with('message','Error remove user');
        }
        if ($user->isClient()){
            if($user->delete()){
                return redirect()->back()->with('message','User have been removed and deleted');
            }
        }
        return redirect()->back()->with('message','Success remove member');

    }

    public function removeProject(Project $project){
        $this->authorize('destroy',$project);
        $project->members()->detach();
        if ($project->delete())
            return redirect()->route('project');
        return redirect()->back();
    }

}
