<?php

namespace App\Models;

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

    protected $appends = ['profile_image_path', 'driving_license_front_path', 'driving_license_back_path', 'average_rating'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'visible_password',
        'remember_token',
        'ratings',
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
    public function getDrivingLicenseFrontPathAttribute()
    {
        if (isset($this->attributes['driving_license_front'])) {
            $driving_license_front = $this->attributes['driving_license_front'];
            return env('APP_URL') . '/' . $driving_license_front;
        }
        return null;
    }
    public function getDrivingLicenseBackPathAttribute()
    {
        if (isset($this->attributes['driving_license_back'])) {
            $driving_license_back = $this->attributes['driving_license_back'];
            return env('APP_URL') . '/' . $driving_license_back;
        }
        return null;
    }
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
    public function truck_type_detail()
    {
        return $this->belongsTo(TruckTypeDetail::class, 'driver_truck_type', 'id');
    }
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'driver_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'driver_histories', 'driver_id', 'order_id');
    }

    /* Rating */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'driver_id');
    }

    public function getAverageRatingAttribute()
    {
        $average = $this->ratings->avg('rating');
        $average = $average ?? 0;
        if ($this->role != 3) {
            $this->hidden[] = 'average_rating';
            return null;
        }
        return $average;
    }
}
