<?php

namespace Celysium\File\Repositories;

use Celysium\BaseStructure\Repository\BaseRepositoryInterface;

interface FileRepositoryInterface extends BaseRepositoryInterface
{
    public function attach(array $parameters): bool;

    public function detach(array $parameters): bool;
}
