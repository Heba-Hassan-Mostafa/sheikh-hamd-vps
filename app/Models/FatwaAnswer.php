<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FatwaAnswer extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded=[];
    protected $table = 'fatwa_answers';
    protected $dates =['publish_date'];
    public $timestamps = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['fatwa_id'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Fatwa Answer")
        ->dontSubmitEmptyLogs();
    }

     public function fatwa()
    {
        return $this->belongsTo(Fatwa::class , 'fatwa_id');
    }

    public function scopePublish($query)
    {
        return  $query->where('publish_date','<=',Carbon::now()->toDateString());
    }
}