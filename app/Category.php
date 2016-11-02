<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $incrementing = false;

    protected $primaryKey = 'slug';


    protected $hidden = ['updated_at','created_at'];

    public function posts(){
        return $this->hasMany('App\Post','category_slug');
    }

}
