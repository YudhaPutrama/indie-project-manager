<?php

namespace App\Policies;

use App\Project;
use App\User;
use App\Photo;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability){
        if ($user->isAdmin()){
            return true;
        }
    }

    /**
     * Determine whether the user can view the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function view(User $user, Photo $photo)
    {
        return !$photo->project->members->where('id',$user->id)->isEmpty();
    }

    /**
     * Determine whether the user can create photos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isStaff()){
            return true;
        }
        return false;
    }

    public function accept(User $user, Photo $photo){
        return $user->isClient()&&$user->projects()->first()->id==$photo->project->id;
    }

    /**
     * Determine whether the user can update the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function update(User $user, Photo $photo)
    {
//        return $user->isStaff();
        return $user->isStaff() && !$photo->project->members->where('id',$user->id)->isEmpty();
    }

    /**
     * Determine whether the user can delete the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function delete(User $user, Photo $photo)
    {
        return $user->isAdmin()||$user->isStaff();
    }
}
