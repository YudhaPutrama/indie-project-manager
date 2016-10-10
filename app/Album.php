<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public  function videos(){
        return $this->hasMany('App\Video');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'target');
    }
}
