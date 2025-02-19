<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsMail extends Notification
{
    use Queueable;
    protected $contact;
    protected $admin;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contact,$admin)
    {
        $this->contact = $contact;
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
                    ->greeting('Hello Admin, ' .$this->admin->name)
                    ->line('You received an email from :' . $this->contact->name )
                    ->line('Here are the details: ' )
                    ->line('Name: '. $this->contact->name )
                    ->line('Email: '. $this->contact->email  )
                    ->line('Message: '. $this->contact->message  )
                    ->line('Thank you !');
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