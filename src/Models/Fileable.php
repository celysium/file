<?php

namespace Celysium\File\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $file_id
 * @property int $fileable_id
 * @property string $fileable_type
 * @property string $description
 * @property string $type
 * @property array $data
 * @property Model $model
 */
class Fileable extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'fileable_id',
        'fileable_type',
        'description',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    /**
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
