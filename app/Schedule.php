<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'deadline',
    ];

    protected $hidden = [
        'user_id',
        'project_id',
        'created_at',
        'updated_at'
    ];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function user(){
        return $this->belongsTo('App\Project');
    }
}
