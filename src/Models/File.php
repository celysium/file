<?php

namespace Celysium\File\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $path
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    // TODO : has many fileales
}
