<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Photo;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use App\Post;
use App\Project;
use App\Schedule;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Photo::class => PhotoPolicy::class,
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Category::class => CategoryPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


    }
}
