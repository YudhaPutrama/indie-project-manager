<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    //use EntrustUserTrait;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot',
    ];


    public function favorite_projects(){
        return $this->belongsToMany('App\Project', 'favorite_projects');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function projects(){
        return $this->belongsToMany('App\Project','project_members','user_id','project_id');
    }


    public function makeClient(array $options = []){
        $this->role = "client";
        parent::save($options);
    }

    public function makeStaff(array $options = []){
        $this->role = "staff";
        parent::save($options);
    }

    public function makeAdmin(array $options = []){
        $this->role = "admin";
        parent::save($options);
    }


    public function isAdmin(){
        return $this->role == "admin";
    }

    public function isStaff(){
        return $this->role == "staff";
    }

    public function isClient(){
        return $this->role == "client";
    }
}
