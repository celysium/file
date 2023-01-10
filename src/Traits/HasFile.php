<?php

namespace Celysium\File\Traits;

use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasFile
{
    public function files(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(File::class, 'fileable');
    }

    /**
     * @return MorphOne
     */
    public function fileables(): MorphOne
    {
        /** @var Model $this */
        return $this->morphOne(Fileable::class, 'fileable');
    }

    public function attachFile(int $file_id, array $data = [], ?string $type = null, ?string $description = null): Model
    {
        return $this->fileables()->create([
            'file_id' => $file_id,
            'data' => $data,
            'type' => $type,
            'description' => $description,
        ]);
    }

    public function detachFile(int $file_id): bool
    {
        return $this->fileables()
            ->where('file_id', $file_id)
            ->delete();
    }

    public function syncFile(array $files): array
    {
        $data = [];
        foreach ($files as $file) {
            $data[$file['id']] = [
                'data' => $file['data'] ?? [],
                'type' => $file['type'] ?? null,
                'description' => $file['description'] ?? null,
            ];
        }
        return $this->files()->sync($data);
    }
}
