<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory,LogsActivity;

    protected $guarded=[];
    protected $table = 'galleries';
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['title','status','gallery_category_id'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Gallery")
        ->dontSubmitEmptyLogs();
    }

    public function galleryCategory()
    {
        return $this->belongsTo(GalleryCategory::class ,'gallery_category_id' ,'id');
    }

    public function images() : MorphMany
    {
        return $this->morphMany(Image::class , 'imageable');
    }

    public function status()
    {
        return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    }

    //scope active for gallery

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }

    //scope active for gallerycategory
    public function scopeActiveCategory($query)
    {
        return  $query->whereHas('galleryCategory', function($q){

             $q->whereStatus(1);
        });
    }


}
