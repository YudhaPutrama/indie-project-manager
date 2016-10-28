<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string("title");
            $table->unsignedInteger('category_id')->nullable();
            $table->string('image')->nullable();
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table){
            $table->string('slug');
            $table->string('name');
            $table->timestamps();
            $table->primary('slug');
        });


        Schema::create('categories', function (Blueprint $table){
            $table->string('slug');
            $table->string('name');
            $table->timestamps();
            $table->primary('slug');
        });

        Schema::create('post_tags', function (Blueprint $table){
            $table->unsignedInteger('post_id');
            $table->string('tag_slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
        Schema::drop('tags');
        Schema::drop('categories');
        Schema::drop('post_tags');
    }
}
