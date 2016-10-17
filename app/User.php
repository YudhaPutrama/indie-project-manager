<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

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

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function projects(){
        return $this->belongsToMany('App\Project','project_members','user_id','project_id');
    }


    public function save(array $options = [])
    {
        if (parent::save($options)){
            $this->roles()->attach(3);
            return true;
        }
        return false;
    }

}
