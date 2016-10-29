<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public $incrementing = false;

    protected $primaryKey = 'slug';

    protected $hidden = ['updated_at','created_at'];

    public function posts(){
        return $this->belongsToMany('App\Post', 'post_tags', 'tag_slug', 'post_id');
    }
}
