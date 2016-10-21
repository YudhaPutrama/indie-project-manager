<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    //use SoftDeletes;


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
        if (parent::save($options)){
            $this->roles()->attach(3);
            return true;
        }
        return false;
    }

    public function makeStaff(array $options = []){
        if (parent::save($options)){
            $this->roles()->attach(2);
            return true;
        }
        return false;
    }

    public function makeAdmin(array $options = []){
        if (parent::save($options)){
            $this->roles()->attach(1);
            return true;
        }
        return false;
    }

}
