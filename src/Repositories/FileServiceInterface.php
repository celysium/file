<?php

namespace Celysium\File\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface FileServiceInterface
{
    public function list();

    public function create(array $parameters): Model|Builder;

    public function delete();
}
