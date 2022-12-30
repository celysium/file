<?php

namespace Celysium\File\Repositories;

use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{

    public function list(array $parameters): LengthAwarePaginator // TODO : name /see Nasser code/index() ,   callback function , ->when()
    {
        return File::query()
            ->paginate($parameters['per_page'] ?? 20);
    }

    public function store(array $parameters): Model|Builder
    {
        /** @var UploadedFile $image */
        $image = $parameters['image']; // TODO : file

        $path = Storage::putFile('images', $image, 'public'); // TODO : instead of images now()->format('Y/m/d') skype
        // $parameters['path'] instead of $path
        return File::query()
            ->create(array_merge($parameters, [
                'path' => $path
            ]));
    }

    public function delete(array $parameters): bool
    {//TODO : customer flag , to delete file in storage or not
        // TODO : update cache
        // id will be gotten instead of paths
        Fileable::query()
            ->whereIn('file_id', function ($query) use ($parameters) {
                $query->select('id')
                    ->from('files')
                    ->whereIn('path', $parameters)
                    ->get();
            })->delete();

        File::query()
            ->whereIn('path', $fileIds)
            ->delete();

        return Storage::delete($parameters);
    }
}
