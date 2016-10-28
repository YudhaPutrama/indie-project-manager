<?php

use App\Permission;
use App\Project;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FirstSetupData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = new User();
        $admin->email = "admin@indie-corp.com";
        $admin->fullname = "Administrator";
        $admin->nickname = "Admin";
        $admin->username = "admin";
        $admin->password = bcrypt('admin12345');
        $admin->makeAdmin();

        $staff = new User();
        $staff->email = "staff@indie-corp.com";
        $staff->fullname = "Staff";
        $staff->nickname = "Staff";
        $staff->username = "staff";
        $staff->password = bcrypt('staff12345');
        $staff->makeStaff();

        $client = new User();
        $client->email = "client@indie-corp.com";
        $client->fullname = "Client";
        $client->nickname = "Client";
        $client->username = "client";
        $client->password = bcrypt('client12345');
        $client->makeClient();


        $project = new Project();
        $project->user_id = $admin->id;
        $project->name = "The Project";
        $project->description = "About this project";
        $project->start = \Carbon\Carbon::now()->toDateString();
        $project->deadline = \Carbon\Carbon::now()->addMonth(1)->toDateString();
        $project->save();

//        $admin->projects()->attach($project->id);
        $staff->projects()->attach($project->id);
        $client->projects()->attach($project->id);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
