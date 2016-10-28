<?php

use Illuminate\Support\Facades\Schema;
use App\User;
use App\Role;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FirstSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //idenfitication
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username',20)->unique();
            $table->string('password');
            $table->enum('role',['admin','staff','client']);

            //userdata
            $table->string('fullname')->default('');
            $table->string('nickname')->default('');
            $table->string('phone')->default('');
            $table->string('twitter')->default('');
            $table->string('facebook')->default('');
            $table->string('lineid')->default('');
            $table->string('instagram')->default('');

            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_mini')->nullable();
            $table->string('title')->default('');
            $table->string('institution')->default('');


            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('projects', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('description');
            $table->string('picture')->default('default.jpg');
            $table->date('start');
            $table->date('deadline');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('project_members',function (Blueprint $table){
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });


        Schema::create('favorite_projects', function (Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_id');
            $table->primary('user_id','project_id');
        });

        Schema::create('favorite_photos', function (Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photos_id');
            $table->primary('user_id','project_id');
        });

//        Schema::create('gallery', function (Blueprint $table){
//            $table->increments('id');
//            $table->string('title');
//            $table->unsignedInteger('project_id');
//
//            $table->timestamps();
//            $table->softDeletes();
//        });

        Schema::create('photos', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id'); //uploader id
            $table->unsignedInteger('project_id'); //album id
            $table->string('title');
            $table->string('location')->default('');
            $table->string('url');
            $table->string('url_thumb');
            $table->string('status')->default('uploaded'); //uploaded, reviewed, done

            $table->softDeletes();
            $table->timestamps();
        });

//        Schema::create('videos', function (Blueprint $table){
//            $table->increments('id');
//            $table->unsignedInteger('user_id');
//            $table->unsignedInteger('album_id');
//            $table->string('title');
//            $table->string('url');
//
//            $table->timestamps();
//        });

        Schema::create('comments', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photo_id');
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });

//        title: 'Long Event',
//                    start: new Date(y, m, d - 5),
//                    end: new Date(y, m, d - 2),
//                    backgroundColor: Metronic.getBrandColor('green')
        Schema::create('schedules', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_id');
            $table->string('event');
            $table->string('location');
            $table->date('start');
            $table->date('end');
            //$table->string('color');
            $table->string('status'); // done, ongoing, pending

            $table->timestamps();
        });


//        Schema::create('activities', function (Blueprint $table){
//            $table->increments('id');
//            $table->unsignedInteger('user_id');
//            $table->
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('password_resets');
        Schema::drop('projects');
        Schema::drop('project_members');
        Schema::drop('photos');
        Schema::drop('comments');
        Schema::drop('schedules');
        Schema::drop('favorite_projects');
        Schema::drop('favorite_photos');
    }
}
