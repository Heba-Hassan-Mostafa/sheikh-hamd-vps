<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\LiveBroadcastNotification;

class SendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $live;
    public $timeout = 7200;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
     public function __construct($data,$live)
    {
       $this->data = $data;
       $this->live = $live;
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
            ->notify(new LiveBroadcastNotification($this->live));
        }
    }
}
