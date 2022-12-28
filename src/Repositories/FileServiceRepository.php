<?php

namespace Celysium\File\Repositories;

use Celysium\File\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FileServiceRepository implements FileServiceInterface
{

    public function list()
    {
        // TODO: Implement list() method.
    }

    public function create(array $parameters): Model|Builder
    {
        /** @var UploadedFile $image */
        $image = $parameters['image'];

        $extension = $image->extension();

        $path = $image->store('images', 'public');

        return File::query()
            ->create(array_merge($parameters, [
                'path' => $path,
                'extension' => $extension
            ]));
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
