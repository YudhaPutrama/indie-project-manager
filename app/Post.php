<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category', 'category_slug');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'post_tags', 'post_id', 'tag_slug');
    }


}
