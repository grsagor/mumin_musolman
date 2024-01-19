<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckTypeDetail extends Model
{
    use HasFactory;

    protected $appends = ['truck_type'];

    public function truck_type()
    {
        return $this->belongsTo(TruckType::class, 'truck_type_id');
    }
    public function getTruckTypeAttribute()
    {
        return $this->truck_type()->first();
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'truck_type_details_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'driver_truck_type', 'id');
    }
}
