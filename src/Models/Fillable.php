<?php

namespace Celysium\File\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $file_id
 * @property int $fillable_id
 * @property string $fillable_type
 * @property string $type
 * @property array $data
 */
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

    // todo : belogns to file
}
