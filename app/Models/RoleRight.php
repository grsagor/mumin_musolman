<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRight extends Model
{
    use HasFactory;

    protected $table = "role_right";

    protected $fillable = ['role_id', 'right_id', 'permission'];
}
