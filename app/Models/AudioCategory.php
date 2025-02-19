<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AudioCategory extends Model
{
    use HasFactory , Sluggable, LogsActivity;

    protected $guarded=[];
    protected $table = 'audio_categories';
    public $timestamps = true;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name','status'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Audio Category")
        ->dontSubmitEmptyLogs();
    }

    public function audioes()
    {
       return $this->hasMany(Audio::class);
    }


    public function status()
    {
        return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    }

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }


}