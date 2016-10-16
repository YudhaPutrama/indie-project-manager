<?php

use App\Permission;
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
        $staff->description  = 'User is allowed to manage and upload photos'; // optional
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
        $user->save();
        $user->attachRole($admin);

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
