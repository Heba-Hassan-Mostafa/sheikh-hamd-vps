<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonCategory extends Model
{
    use HasFactory , Sluggable, LogsActivity;

    protected $guarded=[];
    protected $table = 'lesson_categories';
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
        ->logOnly(['name','status','parent_id'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Lesson category")
        ->dontSubmitEmptyLogs();
    }

    public function parent()
    {
       return $this->belongsTo(LessonCategory::class,'parent_id');
    }


    public function subcategory()
    {
       return $this->hasMany(LessonCategory::class,'parent_id');
    }

    public function appearedSubcategory()
    {
        return $this->hasMany(LessonCategory::class , 'parent_id' ,'id')->where('status',true);
    }

    public static function tree($level = 20)
    {
        return static::with(implode('.',array_fill(0, $level , 'subcategory')))
        ->with('lessons',function($q){
            $q->whereStatus(1)->count();
        })
        ->whereNull('parent_id')
        ->whereStatus(true)
        ->orderBy('order_position','asc')
        ->get();

    }

    public function lessons()
    {
       return $this->hasMany(Lesson::class);
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