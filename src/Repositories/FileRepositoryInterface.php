<?php

namespace Celysium\File\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface FileRepositoryInterface
{
    public function list(array $parameters): LengthAwarePaginator;

    public function store(array $parameters): Model|Builder;

    public function delete(array $parameters): bool;
}
