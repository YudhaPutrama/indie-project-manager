<?php

namespace App\Notifications;

use App\Photo;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PhotoUpdate extends Notification
{
    use Queueable;

    private $user;
    private $photo;
    private $action;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param Photo $photo
     * @param string $action
     */
    public function __construct(User $user, Photo $photo, $action)
    {
        $this->user = $user;
        $this->photo = $photo;
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
            'user_id'=>$this->user,
            'photo_id'=>$this->photo,
            'action'=>$this->action
        ];
    }
}
