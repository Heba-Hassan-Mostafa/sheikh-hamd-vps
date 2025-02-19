<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscriberBookNotification;

class SendBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $books;
    public $timeout = 7200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   public function __construct($data,$books)
    {
       $this->data = $data;
       $this->books = $books;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         foreach($this->data as $subscriber)
        {
            Notification::route('mail' , $subscriber->email)
            ->notify(new SubscriberBookNotification($this->books,$subscriber));
        }
    }
}
