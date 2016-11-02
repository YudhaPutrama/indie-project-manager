<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        return view('public.homepage');
    }

    public function gallery(){
        return view('public.portfolio');
    }

    public function showPost(){
        return view('public.post');
    }
}
