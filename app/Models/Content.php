<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = substr(uniqid(), 0, 13).'-stlout-'.random_int(10000000000000000, 99999999999999999);
        });
    }
}
