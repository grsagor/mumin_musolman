<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    public function subscribers() {
        return $this->hasMany(ChannelSubscriber::class, 'channel_id');
    }
    public function messages() {
        return $this->hasMany(Message::class, 'channel_id');
    }
}
