<?php

namespace App\Notifications;

use App\Schedule;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ScheduleUpdate extends Notification
{
    use Queueable;

    private $user;
    private $schedule;
    private $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Schedule $schedule, $action)
    {
        $this->user = $user;
        $this->schedule = $schedule;
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
            'schedule'=>$this->schedule,
            'action'=>$this->action
        ];
    }
}
