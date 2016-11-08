<?php

namespace App\Http\Controllers;

use App\User;
use Auth;

use Hash;
use Illuminate\Http\Request;
use Response;
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
            return view('profile-view', ['user'=>$user]);
        }
        return redirect('/');
    }

    public function viewUser(User $user){
        return view('user-view', ['user'=>$user]);
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

    public function updateProfile(Request $request){
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

    public function listUsers(){
        $this->authorize('create', User::class);
        $users = User::with('projects')->get();
        $trashed = User::onlyTrashed()->get();
        return view('user-list',['users'=>$users,'trashed'=>$trashed]);

    }

    public function newUser(Request $request){
        $this->authorize('create', User::class);
        $validator = Validator::make($request->all(), [
            'role'=>'required',
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required'
        ]);
        if ($validator->fails()){
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        }
        $user = new User();
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->password = bcrypt($request->get('password'));
        $user->fullname = $request->get('fullname');
        $user->institution = $request->get('institution');
        $role = $request->get('role');
        if ($role=='admin'){
            $make=$user->makeAdmin();
        } else if ($role=='staff'){
            $make=$user->makeStaff();
        } else if ($role=='client'){
            $make=$user->makeClient();
        } else {
            return Response::json(['status'=>'error']);
        }
        if ($make){
            return Response::json(['status'=>'success']);
        }
        return Response::json(['status'=>'error']);
    }

    public function resetPassword(User $user, Request $request){

    }

    public function removeUser(User $user){
        $this->authorize('delete', $user);
        if ($user->delete()){
            return Response::json(['status'=>'success']);
        }
        return Response::json(['status'=>'error']);
    }

    public function restore($removedUser){

        if (Auth::user()->isAdmin())
            if (User::withTrashed()
                ->where('id', $removedUser)
                ->restore()){
                return redirect()->back()->with('message','Success Restore');
            }
        return redirect()->back()->with('message','Error restore');
    }

    public function removeForce($removedUser){
        if (Auth::user()->isAdmin())
            if (User::withTrashed()
                ->where('id', $removedUser)
                ->forceDelete()){
                return redirect()->back()->with('message','Success Force Remove');
            }
        return redirect()->back()->with('message','Error Remove');
    }

    public function deleteAll(){
        if (Auth::user()->isAdmin()){
            if(User::onlyTrashed()->forceDetele())
                return redirect()->back()->with('message','Success Force Delete All');
        }
        return redirect()->back();
    }

    public function restoreAll(){
        if (Auth::user()->isAdmin()){
            if(User::onlyTrashed()->restore())
                return redirect()->back()->with('message','Success Restore All');
        }
        return redirect()->back();
    }

    public function checkUsername(Request $request){
        if(Auth::user()->isClient()){
            if (User::where('username',$request->get('username')))
            return Response::json(['status'=>'success']);
        }
        return Response::json(['status'=>'error']);
    }
}
