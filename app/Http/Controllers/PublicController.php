<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        $posts = Post::all()->take('3');
//        return $posts;
        return view('public.homepage', ['posts'=>$posts]);
    }

    public function gallery(){
        return view('public.portfolio');
    }

    public function post(Post $post){

        return view('public.post',['post'=>$post]);
    }

    public function about(){
        return view('public.about');
    }

}
