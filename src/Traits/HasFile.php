<?php

namespace Celysium\File\Traits;

use Celysium\File\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasFile
{
    public function files(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(File::class, 'fillable');
    }
}
