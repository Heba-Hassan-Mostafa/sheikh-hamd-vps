<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory ,LogsActivity;

    protected $guarded = [];
    protected $table = 'attachments';


     public function attachmentable() : MorphTo
    {
        return $this->morphTo();
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['file_name'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Pdf")
        ->dontSubmitEmptyLogs();
    }
}