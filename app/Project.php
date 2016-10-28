<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $with = ['photos','members','schedule'];

    protected $hidden = ['pivot'];

    protected $fillable = ['name','description', 'picture'];

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



    public function getPercentsAttribute(){
        $a = Project::all();

        return false;
    }
}
