<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model implements Searchable
{
    use HasFactory ,Sluggable ,LogsActivity;

    protected $guarded=[];
    protected $table = 'lessons';
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
        ->logOnly(['name','status','lesson_category_id','keywords','description'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Lesson")
        ->dontSubmitEmptyLogs();
    }




    public function getSearchResult(): SearchResult
    {
        $url = route('frontend.lessons.lesson_content', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url,
        );
    }

    //get categories of lessons
     public function category()
    {
        return $this->belongsTo(LessonCategory::class , 'lesson_category_id' ,'id');
    }

    //get pdf files of lessons
     public function attachments() : MorphMany
     {
         return $this->morphMany(Attachment::class , 'attachmentable');
     }

     // get audio files of lessons
     public function audioes() : MorphMany
     {
         return $this->morphMany(Audio::class , 'audioable');
     }

       // get videos files of lessons
       public function videos() : MorphMany
       {
           return $this->morphMany(Video::class , 'videoable');
       }


        // get image of lessons
       public function image() : MorphOne
       {
           return $this->morphOne(Image::class , 'imageable');
       }

        //get comments of lessons
     public function comments() : MorphMany
     {
         return $this->morphMany(Comment::class , 'commentable');
     }

     public function wishes() : MorphMany
     {
         return $this->morphMany(Wish::class , 'wishable');
     }

    public function status()
    {
        return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    }

    //scope active for lessons

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }

    //scope active forlessoncategory
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