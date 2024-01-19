<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverHistory extends Model
{
    use HasFactory;

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }
}
