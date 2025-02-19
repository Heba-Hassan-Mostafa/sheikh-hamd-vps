<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matwiaat extends Model
{
    use HasFactory,LogsActivity;

    protected $guarded=[];
    protected $table = 'matwiaats';
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['title','status','image','pdf_file'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Matwiaat")
        ->dontSubmitEmptyLogs();
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

}