<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Photo extends Model
{
    use Notifiable;

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

    public function setRevision(){
        $this->status = 'revision';
        $this->save();
    }

    public function setDone(){
        $this->status = 'done';
        $this->save();
    }

    public function isDone(){
        return $this->status == 'done';
    }

    public function isRevision(){
        return $this->status == 'revision';
    }

    public function isReviewed(){
        return $this->status == 'reviewed';
    }

    public function isUploaded(){
        return $this->status == 'uploaded';
    }
}
