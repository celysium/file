<?php

namespace Celysium\File\Controllers;

use Celysium\BaseStructure\Controller\Controller;
use Celysium\File\Repositories\FileRepositoryInterface;
use Celysium\File\Requests\File\StoreRequest;
use Celysium\File\Requests\File\DeleteRequest;
use Celysium\File\Resources\FileResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(protected FileRepositoryInterface $fileService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $listedFiles = $this->fileService->index($request->all());

        return Responser::collection(FileResource::collection($listedFiles));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $file = $this->fileService->store($request->validated());

        return Responser::created(new FileResource($file));
    }

    public function delete(DeleteRequest $request): JsonResponse
    {
        $this->fileService->delete($request->validated());

        return Responser::deleted();
    }
}
