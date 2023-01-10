<?php

namespace Celysium\File\Repositories;

use Celysium\BaseStructure\Repository\BaseRepository;
use Celysium\File\Events\DetachFile;
use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct(protected File $file)
    {
        parent::__construct($file);
    }

    /**
     * @throws ValidationException
     */
    public function store(array $parameters): Model
    {
        $parameters['mime_type'] = $parameters['file']->extension();

        $parameters['path'] = Storage::putFile(
            now()->format('Y/m/d'),
            $parameters['file'],
            'public'
        );

        if (!$parameters['path']) {
            throw ValidationException::withMessages([
                'file' => [__('file::message.not_enough_space')]
            ]);
        }

        return $this->model
            ->query()
            ->create($parameters);
    }

    /**
     * @throws ValidationException
     */
    public function delete(array $parameters): bool
    {
        DB::beginTransaction();

        $fileables = Fileable::query()
            ->whereIn('file_id', $parameters['files'])
            ->distinct('fileable_id', 'fileable_type')
            ->get();

        /** @var Fileable $fileable */
        foreach ($fileables as $fileable) {
            if ($fileable->delete()) {
                DetachFile::dispatch($fileable);
            }
            else {
                throw ValidationException::withMessages([
                    'files' => [__('file::message.could_not_delete')]
                ]);
            }
        }

        if (!empty($parameters['is_force_delete'])) {
            $paths = $this->model->query()
                ->whereIn('id', $parameters['files'])
                ->get(['path'])
                ->toArray();

            $this->model->query()
                ->whereIn('id', $parameters['files'])
                ->delete();

            $result = Storage::delete($paths);

            if (! $result) {
                throw ValidationException::withMessages([
                    'is_force_delete' => [__('file::message.could_not_delete')]
                ]);
            }
        }
        DB::commit();

        return true;
    }

    public function applyFilters(Builder $query = null, array $parameters = []): Builder
    {
        if (isset($parameters['path'])) {
            $query->where('path', $parameters['path']);
        }

        return parent::applyFilters($query, $parameters);
    }
}
