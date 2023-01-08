<?php

namespace Celysium\File\Repositories;

use Celysium\BaseStructure\Repository\BaseRepositoryInterface;

interface FileRepositoryInterface extends BaseRepositoryInterface
{
    public function delete(array $parameters);
}
