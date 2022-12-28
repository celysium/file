<?php

namespace Celysium\File\Repositories;

interface FileServiceInterface
{
    public function list();

    public function create();

    public function delete();
}
