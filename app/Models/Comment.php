<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, LogsActivity ;

    protected $guarded=[];
    protected $table = 'comments';
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['status'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Comment")
        ->dontSubmitEmptyLogs();
    }

    public function commentable() : MorphTo
    {
        return $this->morphTo();
    }

     //get comments of clients
     public function client()
    {
        return $this->belongsTo(Client::class , 'client_id' ,'id');
    }

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }

}