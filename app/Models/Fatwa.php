<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fatwa extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded=[];
    protected $table = 'fatwas';
    public $timestamps = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name','status'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Fatwa")
        ->dontSubmitEmptyLogs();
    }
    public function client()
    {
        return $this->belongsTo(Client::class , 'client_id');
    }

    public function fatwa_answer()
    {
        return $this->hasOne(FatwaAnswer::class , 'fatwa_id');
    }

    public function status()
    {
        return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    }

    public function scopeHasAnswer($query)
    {
        return $query->whereHas('fatwa_answer', function ($query) {

            $query->where('answer' , '!=' ,'')
          ->orWhere('audio_file' , '!=' ,'');

   });


    }



    public function scopeActive($query)
     {
         return  $query->whereStatus(1);
     }
}