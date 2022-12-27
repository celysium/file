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
        return $this->morphToMany(File::class, 'fileable');
    }

    // TODO : morphmany -> mane class (__CLASS__) yek morph many daram , biyad record haro az jadval vasat bekhune
}
