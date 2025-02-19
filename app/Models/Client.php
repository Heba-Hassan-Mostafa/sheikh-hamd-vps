<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $table = 'clients';
     protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'status',
        'email',
        'password',
        'provider',
        'provider_id'
    ];
    protected static $recordEvents = ['deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['status'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} in the Client")
        ->dontSubmitEmptyLogs();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() :string
    {
        return ucfirst($this->first_name) .' '. ucfirst( $this->last_name);

    }

    public function comments()
    {
       return $this->hasMany(Comment::class,'client_id','id');
    }

    public function fatwas()
    {
       return $this->hasMany(Fatwa::class,'client_id','id');
    }

    public function wishes()
    {
       return $this->hasMany(Wish::class,'client_id','id');
    }

    // public function status()
    // {
    //     return $this->status ?   trans('btns.active') :  trans('btns.inactive') ;
    // }

}