<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckType extends Model
{
    use HasFactory;

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        $image = $this->attributes['image'];
        return env('APP_URL') . '/' . $image;
    }

    public function truck_type_details()
    {
        return $this->hasMany(TruckTypeDetail::class);
    }
}
