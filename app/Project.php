<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $hidden = ['pivot'];

    public function creator(){
        return $this->belongsTo('App\User', 'created_by');
    }

    public function members(){
        return $this->belongsToMany('App\User', 'project_members');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public function schedule(){
        return $this->hasMany('App\Schedule');
    }
}
