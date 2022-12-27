<?php

namespace Celysium\ACL\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fillable extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'fillable_id',
        'fillable_type',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
