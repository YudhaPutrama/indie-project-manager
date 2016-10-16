<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function user(){
        return $this->hasOne('App\User');
    }


    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
