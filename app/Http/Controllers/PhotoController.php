<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Project;
use App\User;
use Auth;

class PhotoController extends Controller
{
    public function showPhoto($id, $photo_id){
        $user = Auth::user();
        //return User::with('projects.photos')->find($user->id);
        $photo = Photo::with('comments.user')->find($photo_id);
        $comments = $photo['comments'];

        return view('photos',['user'=>$user,'photo'=>$photo, 'comments' => $comments]);
    }
}
