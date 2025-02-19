<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model implements Searchable
{
    use HasFactory ,Sluggable ,LogsActivity;

    protected $guarded=[];
    protected $table = 'articles';
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
        ->logOnly(['name','status','article_category_id','keywords','description'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Article")
        ->dontSubmitEmptyLogs();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('frontend.articles.article_content', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url,
        );
    }

    //get categories of articles
     public function category()
    {
        return $this->belongsTo(ArticleCategory::class , 'article_category_id' ,'id');
    }

    //get pdf files of articles
     public function attachments() : MorphMany
     {
         return $this->morphMany(Attachment::class , 'attachmentable');
     }

     // get audio files of articles
     public function audioes() : MorphMany
     {
         return $this->morphMany(Audio::class , 'audioable');
     }

       // get videos files of articles
       public function videos() : MorphMany
       {
           return $this->morphMany(Video::class , 'videoable');
       }


        // get image of articles
       public function image() : MorphOne
       {
           return $this->morphOne(Image::class , 'imageable');
       }

        //get comments of articles
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

     //scope active for articles

     public function scopeActive($query)
     {
         return  $query->whereStatus(1);
     }

     //scope active for articlecategory
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