<?php

namespace Celysium\File\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $path
 * @property string $description
 */
class File extends Model
{
    protected $fillable = [
        'path',
        'description',
    ];

    use HasFactory;

    public function fileables(): HasMany
    {
        return $this->hasMany(Fileable::class);
    }
}
