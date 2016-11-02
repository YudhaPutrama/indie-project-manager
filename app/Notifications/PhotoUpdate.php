<?php

namespace App\Notifications;

use App\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PhotoUpdate extends Notification
{
    use Queueable;

    private $photo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($photo)
    {
        $this->photo = $photo;
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
            'photo_id'=>$this->photo->id,
        ];
    }

    public function toPhoto($notifiable){
        return $this->photo;
    }
}
