<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->hasOne('App\Category');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'post_tags', 'post_id', 'tag_slug');
    }


}
