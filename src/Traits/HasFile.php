<?php

namespace Celysium\File\Traits;

use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasFile
{
    public function files(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(File::class, 'fileable');
    }

    public function fileables(): MorphMany
    {
        /** @var Model $this */
        return $this->morphMany(Fileable::class,' fileable');
    }

    public function file(array $ids)
    {
        return $this->files()->sync($ids);
    }
}
