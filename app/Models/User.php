<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "user";
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    protected $appends = ['profile_image_path', 'chat', 'premium'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = random_int(1000, 9999);
        });
    }

    public function getProfileImagePathAttribute()
    {
        $profileImage = $this->attributes['profile_image'];
        return env('APP_URL') . '/' . $profileImage;
    }
    // public function roles()
    // {
    //     return $this->belongsTo(class, 'role', 'id');
    // }
    public function getChatAttribute() {
        if (isset($this->attributes["chat_expiry_date"])) {
            $chat_expiry_date = $this->attributes["chat_expiry_date"];
            $currentDateTime = Carbon::now();
            $chat_expiry_date = Carbon::parse($chat_expiry_date);
            if ($chat_expiry_date->lt($currentDateTime)) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
    public function getPremiumAttribute() {
        if (isset($this->attributes["premium_expiry_date"])) {
            $premium_expiry_date = $this->attributes["premium_expiry_date"];
            $currentDateTime = Carbon::now();
            $premium_expiry_date = Carbon::parse($premium_expiry_date);
            if ($premium_expiry_date->lt($currentDateTime)) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
    public function subscribers() {
        return $this->hasMany(ChannelSubscriber::class, 'user_id');
    }
}
