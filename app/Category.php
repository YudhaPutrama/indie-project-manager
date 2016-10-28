<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $hidden = ['updated_at','created_at'];

    public function posts(){
        return $this->belongsToMany('App\Post');
    }

}
