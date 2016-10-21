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
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'User is allowed to manage and edit other users'; // optional
        $admin->save();

        $staff = new Role();
        $staff->name         = 'staff';
        $staff->display_name = 'User Staff'; // optional
        $staff->description  =  'User is allowed to manage and upload photos'; // optional
        $staff->save();

        $client = new Role();
        $client->name         = 'client';
        $client->display_name = 'User Client'; // optional
        $client->description  = 'User is allowed to view and comment photos'; // optional
        $client->save();

        $user = new User();
        $user->email = "admin@admin.com";
        $user->username = "admin";
        $user->password = bcrypt('admin12345');
        $user->makeAdmin();
        //$user->attachRole($admin);

        $client1 = new User();
        $client1->email = "user1@test.com";
        $client1->username = "user1";
        $client1->password = bcrypt('user12345');
        $client1->makeClient();
//        $client1->attachRole($client);

        $project = new Project();
        $project->user_id = $user->id;
        $project->name = "The Project";
        $project->description = "About this project";
        $project->save();

        $user->projects()->attach($project->id);
        $client1->projects()->attach($project->id);


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
