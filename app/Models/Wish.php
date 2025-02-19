<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wish extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table = 'wishes';
    public $timestamps = true;



    public function wishable() : MorphTo
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Client::class ,'client_id' ,'id');
    }

}