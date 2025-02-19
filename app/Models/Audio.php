<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audio extends Model
{
    use HasFactory ,Sluggable,LogsActivity;

    protected $guarded=[];
    protected $table = 'audioes';
    protected $dates =['publish_date'];
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
        ->logOnly(['name','audio_file','embed_link'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Audioes")
        ->dontSubmitEmptyLogs();
    }

     //get categories of articles
     public function category()
     {
         return $this->belongsTo(AudioCategory::class , 'audio_category_id' ,'id');
     }


    public function audioable() : MorphTo
    {
        return $this->morphTo();
    }

    public function status()
    {
        return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    }


     public function scopeActive($query)
     {
         return  $query->whereStatus(1);
     }

     public function scopeActiveCategory($query)
     {
         return  $query->whereHas('category', function($q){

              $q->whereStatus(1);
         });
     }

     public function scopePublish($query)
     {
         return  $query->where('publish_date','<=',Carbon::now()->toDateString());
     }

}