<?php

namespace Celysium\File\Models;

use database\factories\FileFactory;
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
    use HasFactory;

    protected $fillable = [
        'path',
        'description',
    ];

    public function fileables(): HasMany
    {
        return $this->hasMany(Fileable::class);
    }

    protected static function newFactory()
    {
        return FileFactory::new();
    }
}
