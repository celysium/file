<?php

namespace Celysium\File\Controllers;

use Celysium\File\Repositories\FileRepositoryInterface;
use Celysium\File\Requests\CreateFileRequest;
use Celysium\File\Requests\DeleteFileRequest;
use Celysium\File\Resources\FileResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(protected FileRepositoryInterface $fileService)
    {
    }

    public function list(Request $request): JsonResponse
    {
        $listedFiles = $this->fileService->list($request->all());

        return Responser::collection(FileResource::collection($listedFiles));
    }

    public function store(CreateFileRequest $request): JsonResponse
    {
        $file = $this->fileService->store($request->validated());

        return Responser::created(new FileResource($createdFile));
    }

    public function delete(DeleteFileRequest $request): JsonResponse
    {
        return Responser::deleted(
            $this->fileService->delete($request->validated())
        );
    }
}
