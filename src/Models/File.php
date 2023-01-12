<?php

namespace Celysium\File\Models;

use Carbon\Carbon;
use Celysium\File\Database\Factories\FileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $path
 * @property string $description
 * @property string $mime_type
 * @property Carbon $created_at
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'description',
        'mime_type',
    ];

    public const UPDATED_AT = null;

    public function fileables(): HasMany
    {
        return $this->hasMany(Fileable::class);
    }

    protected static function newFactory(): FileFactory
    {
        return new FileFactory();
    }
}
