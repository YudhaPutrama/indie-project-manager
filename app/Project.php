<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function creator(){
        $this->belongsTo('App\User');
    }

    public function members(){
        $this->belongsToMany('App\User', 'project_members');
    }

}
