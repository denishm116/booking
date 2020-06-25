<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminMessage extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Здравствуйте, ' . $notifiable->name . '. Собщение от krim-leto.ru')
            ->greeting('Здравствуйте, ' . $notifiable->name . '!')

            ->line($this->message);

    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
