<?php

use Illuminate\Support\Facades\Schema;
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
            $table->integer('user_type');

            //userdata
            $table->string('name');
            $table->string('phone',15);
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
            $table->string('title');
            $table->string('description');
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

        Schema::create('albums', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('project_id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('photos', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id'); //uploader id
            $table->unsignedInteger('album_id'); //album id
            $table->string('title');
            $table->string('url');
            $table->string('status');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('album_id');
            $table->string('title');
            $table->string('url');

            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table){
            $table->increments('id');
            $table->text('body');
            $table->unsignedInteger('target_id');
            $table->string('target_type');
            $table->timestamps();
            $table->softDeletes();
        });


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
        Schema::drop('albums');
        Schema::drop('photos');
        Schema::drop('videos');
        Schema::drop('comments');
    }
}
