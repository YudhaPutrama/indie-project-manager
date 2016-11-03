<?php

namespace App\Notifications;

use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectUpdate extends Notification
{
    use Queueable;

    private $user;
    /**
     * @var \App\Project
     */
    private $project;


    private $action;
    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param \App\Project $project
     * @param string $action
     */
    public function __construct(User $user, Project $project, $action)
    {
        $this->user = $user;
        $this->project = $project;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user'=>$this->user,
            'project'=>$this->project,
            'action'=>$this->action
        ];
    }
}
