<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photo;
use App\Project;
use App\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Image;
use Intervention\Image\Exception\NotWritableException;
use Log;
use Response;
use Validator;

class PhotoController extends Controller
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Project
     */
    private $project;

    /**
     * @var \App\Photo
     */
    private $photo;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        return $request;
    }

    public function showPhoto(Project $project, Photo $photo){
        //return $photo;
        $user = Auth::user();
        //return User::with('projects.photos')->find($user->id);
        //$photo = Photo::with('comments.user')->find($photo_id);
        $comments = $photo['comments'];

        return view('photos',['user'=>$user,'photo'=>$photo, 'comments' => $comments]);
    }

    public function update(Request $request, Project $project, Photo $photo){
        if ($request->get('action')=='detail'){
            return $this->updateDetail($request, $project, $photo);
        }
        elseif ($request->get('action')=='revision'){
            return $this->revision($request, $project, $photo);
        }
        else {return Response::json(['status'=>'error']);}
    }

    public function updateDetail(Request $request, Project $project, Photo $photo){
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'location'=>'required',
            //'photo'=>'image',
            'status'=>'required'
        ]);
        if ($validator->fails()){
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        }
        $user_id = Auth::user()->id;
        if ($request->hasFile('photo')){
            Log::debug("has File photo");
            $file = $request->file('photo');
            $filename_full = $project->id.'_'.$user_id.'_'.time().'_full'.'.'.$file->getClientOriginalExtension();
            $filename_icon = $project->id.'_'.$user_id.'_'.time().'_icon'.'.'.$file->getClientOriginalExtension();

            //save full size
            Image::make($file)->save(public_path(Config::get('image.dir.projects.photos')).$filename_full);

            //save icon size
            Image::make($file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path(Config::get('image.dir.projects.photos')).$filename_icon);
            $photo->url = $filename_full;
            $photo->url_thumb = $filename_icon;

        }
        $photo->title = $request->get('title');
        $photo->status = $request->get('status');
        $photo->location = $request->get('location');
        if ($photo->save()){
            //return $image_full;
            return Response::json(['status'=>'success','photo'=>$photo]);
        }
        return Response::json(['status'=>'error']);
    }

    public function revision(Request $request, Project $project, Photo $photo){
        $validator = Validator::make($request->all(), [
            'photo'=>'required|image',
        ]);
        if ($validator->fails()){
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        }
        $user_id = Auth::user()->id;

        Log::debug("has File photo");
        $file = $request->file('photo');
        $filename_full = $project->id.'_'.$user_id.'_'.time().'_full'.'.'.$file->getClientOriginalExtension();
        $filename_icon = $project->id.'_'.$user_id.'_'.time().'_icon'.'.'.$file->getClientOriginalExtension();
        try {
            //save full size
            Image::make($file)->save(public_path(Config::get('image.dir.projects.photos')).$filename_full);

            //save icon size
            Image::make($file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path(Config::get('image.dir.projects.photos')).$filename_icon);
            $photo->url = $filename_full;
            $photo->url_thumb = $filename_icon;
            $photo->status = 'reviewed';

            if ($photo->save()){
                return Response::json(['status'=>'success','photo'=>$photo]);
            }
        } catch (NotWritableException $ex){
            return Response::json(['status'=>'error']);
        }


        return Response::json(['status'=>'error']);
    }

    public function deletePhoto(Project $project, Photo $photo){
        $this->authorize('delete', $photo);
        $photo->delete();

    }

    public function acceptPhoto(Project $project, Photo $photo){
        $this->authorize('accept', $photo);
        $photo->setDone();
        return redirect()->back()->with('message','Accepted Photo');
    }

    public function postComment(Project $project, Photo $photo, Request $request){
        //return \Response::json(['test'=>'data']);
        //$this->authorize('create', Comment::class);

        $validator = Validator::make($request->all(), ['message'=>'required']);
        if ($validator->fails()){
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        }
        $comment = new Comment(['user_id'=>Auth::user()->id,'body'=>$request->get('message')]);
        //return $comment;
        if ($photo->comments()->save($comment)){
            return Response::json(['status'=>'success','user'=>Auth::user()]);
        }
    }

}
