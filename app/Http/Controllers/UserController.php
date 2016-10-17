<?php

namespace App\Http\Controllers;

use App\User;
use Auth;

use Hash;
use Illuminate\Http\Request;
use Validator;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showListUser(){
        $users = User::all();

    }

    public function showUser($id){
//        return $user = User::find($id);
        $user = User::find($id);
        if ($user!=null){
            $comments=$user->comments;
            return view('profile-view', ['user'=>$user,'comments'=>$comments]);
        }
        return redirect('/home');
    }

    public function addUser(Request $request){

    }

    public function showProfile(){
        $id = Auth::user()->id;
        return $this->showUser($id);
    }

    public function showProfileEdit(){
        $user = Auth::user();
        $data =['user'=>$user];
        return view('profile-edit', $data);
    }

    public function editProfile(Request $request){
        $data = $request->only([
            'fullname',
            'nickname'
        ]);
    }

    public function uploadAvatar(Request $request){

        if ($request->hasFile('avatar')){
            $validator = Validator::make($request->all(), ['avatar' => 'image']);
            if ($validator->fails()){
                return json_encode(['status'=>'notImage']);
            }
            $user = Auth::user();
            $avatar = $request->file('avatar');
            $userid = $user->id;
            $filename = time().'_'.$userid.'.'.$avatar->getClientOriginalExtension();
            if (Image::make($avatar)->save(public_path('/uploads/original/'.$filename))){
                Image::make($avatar)->fit(300, 300)->save(public_path('/uploads/avatar/'.$filename));
                $user->avatar = $filename;
                if ($user->save()){
                    return json_encode(['status'=>'success']);
                }
            }
            return json_encode(['status'=>'failed']);
        } else if ($request->get('update')){
            $data = $request->only(['fullname','nickname','phone','title','institution','bio','facebook','twitter']);
            $validator = Validator::make($data,[
                'fullname' => 'string',
                'nickname' => 'string',
                'phone' => 'numeric',
                'title' => 'string',
                'institution' => 'string',
                'bio' => 'string'
            ]);
            if ($validator->passes()){
                $user = Auth::user();
                $user->fullname = $data['fullname'];
                $user->nickname = $data['nickname'];
                $user->phone = $data['phone'];
                $user->title = $data['title'];
                $user->institution = $data['institution'];
                $user->bio = $data['bio'];
                if ($user->save()){
                    return json_encode(['status'=>'success']);
                }
            }
        } else if ($request->get('change-password')){
            $data = $request->only(['currentpassword','newpassword','newpassword_confirmation']);
            $validator = Validator::make($data,[
                'currentpassword'=>'required',
                'newpassword'=>'required|confirmed',
                'newpassword_confirmation'=>'required'
            ]);
            if ($validator->passes()){
                $user = Auth::user();

                if (Hash::check($data['currentpassword'], $user->password)){
                    $user->password = bcrypt($data['newpassword']);
                    if ($user->save()){
                        return json_encode(['status'=>'success']);
                    }
                    return json_encode(['status'=>'noChange']);
                }
            } else {
                return json_encode(['status'=>'notValided','error'=>$validator->errors()->first()]);
            }
        }
        return json_encode(['status'=>'error']);
    }


}
