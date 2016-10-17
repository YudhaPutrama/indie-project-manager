<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photo;
use App\Project;
use App\User;
use Auth;
use Illuminate\Http\Request;
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

    public function postComment(Project $project, Photo $photo, Request $request){
        //return \Response::json(['test'=>'data']);
        //$this->authorize('create', Comment::class);

        $validator = Validator::make($request->all(), ['message'=>'required']);
        if ($validator->fails()){
            return Response::json(['status'=>'error'],404);
        }
        $comment = new Comment(['user_id'=>Auth::user()->id,'body'=>$request->get('message')]);
        //return $comment;
        if ($photo->comments()->save($comment)){
            return Response::json(['status'=>'success','user'=>Auth::user()]);
        }
    }
}
