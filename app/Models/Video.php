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

class Video extends Model
{
    use HasFactory ,Sluggable,LogsActivity;

    protected $guarded=[];
    protected $table = 'videos';
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
        ->logOnly(['name','youtube_link','video_file'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Video")
        ->dontSubmitEmptyLogs();
    }

    public function videoable() : MorphTo
    {
        return $this->morphTo();
    }

      //get categories of articles
      public function category()
      {
          return $this->belongsTo(VideoCategory::class , 'video_category_id' ,'id');
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