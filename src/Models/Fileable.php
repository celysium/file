<?php

namespace Celysium\File\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $file_id
 * @property int $fileable_id
 * @property string $fileable_type
 * @property string $type
 * @property array $data
 */
class Fileable extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'fileable_id',
        'fileable_type',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'array'
    ];

    // todo : belogns to file
}
