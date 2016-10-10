<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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

    public function index(){

    }

    public function create(Request $request){

    }

    public function show($id){

    }

    public function showGallery($id){

    }

    public function showMembers($id){

    }

    public function newGallery($id){

    }

    public function addMember(){

    }
}
