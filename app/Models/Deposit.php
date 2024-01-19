<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $appends = ['document_path'];

    public function getDocumentPathAttribute()
    {
        $document = $this->attributes['document'];
        return env('APP_URL') . '/' . $document;
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
