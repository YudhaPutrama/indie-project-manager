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

    public function hasMember(User $user){
        return !$this->project->members->where('id',$user->id)->isEmpty();
    }

    public function setReviewed(){
        $this->status = 'reviewed';
        $this->save();
    }

    public function setDone(){
        $this->status = 'done';
        $this->save();
    }
}
