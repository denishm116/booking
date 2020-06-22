<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendPassword extends Notification
{
    use Queueable;

    private $pass;

    public function __construct($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Здравствуйте, ' . $notifiable->name . '. Вы зарегистрированы на сервисе krim-leto.ru')
            ->greeting('Здравствуйте, ' . $notifiable->name . '!')
            ->line('Для входа на сайт https://krim-leto.ru используйте:')
            ->line('Логин:')
            ->line($notifiable->email)
            ->line('Пароль: ')
            ->line($this->pass)
            ->line('Для того, чтобы изменить пароль, нажмите на кнопку')
            ->action('Изменить пароль', url('https://krim-leto.ru/password/reset'));


    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
