<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photo;
use App\Project;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()){
            $projects = Project::all()->where('created_at','>=', Carbon::now()->addMonths(-1));
            $comments = Comment::all()->where('created_at','>=', Carbon::now()->addMonths(-1));
            $photos = Photo::all()->where('created_at','>=', Carbon::now()->addMonths(-1));


            return view('dashboard',['comments'=>$comments, 'photos'=>$photos, 'projects'=>$projects]);
        }
        return redirect('/projects');
    }

    public function notifications(){
        return view('notifications');
    }
}
