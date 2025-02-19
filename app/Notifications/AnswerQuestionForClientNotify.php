<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnswerQuestionForClientNotify extends Notification
{
    use Queueable;
    protected $fatwa;
    protected $admin;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fatwa,$admin)
    {
        $this->fatwa = $fatwa;
        $this->admin = $admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('New Message is Received.')
                    ->greeting('Hello, '. $this->admin->full_name)
                    ->line('There is Anew Question is Asked ,Please Check It!')
                    ->line('Thanks.');

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
            //
        ];
    }
}
