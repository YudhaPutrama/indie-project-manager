<?php

namespace App\Http\Controllers;

use App\Project;
use App\Schedule;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use Validator;

class ScheduleController extends Controller
{


    //if client to show schr
    public function handleSchedule(){
        return view('schedule-view');
    }

    public function listSchedule(){
        if (Auth::user()->isClient()){
            $project=Auth::user()->projects()->first();
            if ($project==null)
                return view('no-project');
            return redirect()->route('projectCalendar', ['project'=>$project]);
        }
        $events = Schedule::all();
        return view('schedule-edit', ['events'=>$events]);
    }

    public function postSchedule(Project $project, Request $request){
        $data = $request->only(['name','location','start','deadline']);
        $validator = Validator::make($data,[
            'name'=>'required',
            'location'=>'required',
            'start'=>'required|date',
            'deadline'=>'required|date|after:start'
        ]);

        if ($validator->passes()){
            $event = new Schedule();
            $event->event = $data['name'];
            $event->location = $data['location'];
            $event->start = $data['start'];
            $event->end = $data['deadline'];
            $event->user_id = Auth::user()->id;
            $event->project_id = $project->id;
            $event->status = 'pending';
            if ($event->save()){
                return Response::json(['status'=>'success']);
            }
            return Response::json(['status'=>'failedSave']);
        }
        return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);

    }

    public function dataSchedule(Project $project){
        return $project->schedule;

//        return view('schedule-view',['events'=>$events]);
    }

    public function projectSchedule(Project $project){
        $events = $project->schedule;
        //return $data;
        return view('schedule-view',['events'=>$events]);
    }

    public function showSchedule(){
        return view('schedule-view');
    }

    public function request(){

    }

    public function edit(Project $project, Schedule $event)
    {

    }

    public function remove(Project $project, Schedule $event)
    {
        $this->authorize('delete',$event);
        if ($event->delete()){
            return Response::json(['status'=>'success','detail'=>'Success remove event']);
        }
        return Response::json(['status'=>'error']);
    }

    public function accept(Project $project, Schedule $event){
        $this->authorize('update', $project);
        $event->status = 'ongoing';
        if ($event->save()){
            return Response::json(['status'=>'success']);
        }
        return Response::json(['status'=>'error']);
    }

    public function done(Project $project, Schedule $event){
        $this->authorize('update', $project);
        $event->status = 'done';
        if ($event->save()){
            return Response::json(['status'=>'success']);
        }
        return Response::json(['status'=>'error']);
    }
}

