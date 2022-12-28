<?php

namespace Celysium\File\Controllers;

use Celysium\File\Repositories\FileServiceInterface;
use Celysium\File\Requests\CreateFileRequest;

class FileController extends Controller
{
    public function __construct(protected FileServiceInterface $fileService)
    {
    }

    public function list()
    {

    }

    public function create(CreateFileRequest $request)
    {
        $validatedData = $request->validated();

        return $this->fileService->create($validatedData);
    }

    public function delete()
    {

    }
}
