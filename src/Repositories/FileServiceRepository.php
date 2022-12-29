<?php

namespace Celysium\File\Repositories;

use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileServiceRepository implements FileServiceInterface
{

    public function list(array $parameters): LengthAwarePaginator
    {
        return File::query()
            ->paginate($parameters['paginate_per_page'] ?? 20);
    }

    public function store(array $parameters): Model|Builder
    {
        /** @var UploadedFile $image */
        $image = $parameters['image'];

        $path = Storage::putFile('images', $image, 'public');

        return File::query()
            ->create(array_merge($parameters, [
                'path' => $path
            ]));
    }

    public function delete(array $parameters): bool
    {
        $fileIds = File::query()
            ->select('id')
            ->where('path', $parameters)
            ->get()
            ->toArray();

        Fileable::query()
            ->whereIn('file_id', $fileIds)
            ->delete();

        File::query()
            ->whereIn('id', $fileIds)
            ->delete();

        return Storage::delete($parameters);
    }
}
