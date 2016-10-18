<?php

namespace App\Providers;

use App\Comment;
use App\Photo;
use App\Policies\CommentPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\UserPolicy;
use App\Project;
use App\Schedule;
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
        Comment::class => CommentPolicy::class,
        Photo::class => PhotoPolicy::class,
        Project::class => ProjectPolicy::class,
        Schedule::class => SchedulePolicy::class,
        User::class => UserPolicy::class,
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
