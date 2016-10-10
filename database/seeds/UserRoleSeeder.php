<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'Administrator'; // optional
        $admin->save();

        $staff = new \App\Role();
        $staff->name         = 'staff';
        $staff->display_name = 'User Staff'; // optional
        $staff->description  = 'Pegawai'; // optional
        $staff->save();

        $client = new \App\Role();
        $client->name         = 'client';
        $client->display_name = 'User Client'; // optional
        $client->description  = 'Pelanggan'; // optional
        $client->save();
    }
}
