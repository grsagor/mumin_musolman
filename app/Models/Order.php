<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = 'RID' . random_int(100000, 999999);
        });
    }

    protected $appends = ['truck_detail'];

    public function getTruckDetailAttribute()
    {
        return $this->truck_detail()->first();
    }

    public function truck_detail()
    {
        return $this->belongsTo(TruckTypeDetail::class, 'truck_type_details_id');
    }
    public function drivers()
    {
        return $this->belongsToMany(User::class, 'driver_histories', 'order_id', 'driver_id');
    }

}
