<?php

namespace App\Http\Controllers;

use App\Photo;
use Auth;
use Config;
use Image;
use Response;
use Validator;
use App\Project;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    /**
     * @var \App\User
     */
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    public function listProject(){
        if (Auth::user()->hasRole('admin')){
            $projects = Project::with('members')->all();
        } else {
            $projects = $this->user->projects;
        }
        return view('project-list',$projects);
    }

    public function client(){
        return $this->showProjectDetail(Auth::user()->projects()->first());
    }

    public function showProject(){
        $user = Auth::user();
        if (Auth::user()->hasRole('admin')||Auth::user()){
            $projects = Project::all();
            //return ['user'=>$user,'projects'=>$projects];
            return view('project-list',['user'=>$user,'projects'=>$projects]);
        } elseif (Auth::user()->hasRole('staff')) {
            $projects = Auth::user()->projects;
            return view('project-list',['user'=>$user,'projects'=>$projects]);
        } else {
            $project = Auth::user()->projects()->first();
            return view('project-detail',['user'=>$user, 'project'=>$project]);
        }
    }


    public function showProjectDetail(Project $project){
        if (Auth::user()->hasRole('client')){
            return redirect('/projects')->with('error',"You does'nt have an access");
            //$project = Auth::user()->projects()->first();
        }
        if (($project)==null){
            return redirect('/projects')->with('error',"Projects not found");
        }
        $data = [
            'user' => Auth::user(),
            'project' => $project
        ];
        //return $data;
        return view('project-detail',$data);
    }

    public function showUpload(Project $project){
        return view('upload');
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

            //save full size
            $image_full = Image::make($file)->save(public_path(Config::get('image.dir.projects.photos')).$filename_full);

            //save icon size
            $image_icon = Image::make($file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path(Config::get('image.dir.projects.photos')).$filename_icon);

            $photo = new Photo();
            $photo->user_id = Auth::user()->id;
            $photo->title = "Project Photo";
            $photo->url = $filename_full;
            $photo->url_thumb = $filename_icon;
            $photo->status = "uploaded";


            if ($project->photos()->save($photo)){
                //return $image_full;
                return Response::json(['status'=>'success'],200);
            }
        }
        return Response::json(['status'=>'error']);
    }

    public function showMembers(){

    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(200, null, function ($constraint){
            $constraint->aspectRatio();
        })->save( Config::get('image.dir.projects.photos')  . $filename );

        return $image;
    }
}
