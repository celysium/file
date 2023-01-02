<?php

namespace Celysium\File\Repositories;

use Celysium\BaseStructure\Repository\BaseRepository;
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
        $parameters['path'] = Storage::putFile(
            now()->format('Y/m/d'),
            $parameters['file'], 'public'
        );

        if (! $parameters['file_path']) {
            throw ValidationException::withMessages(['storage' => [__('file::file.Storage is full')]]);
        }

        return parent::store($parameters);
    }

    public function delete(array $parameters): bool
    {
        $fileQuery = File::query();

        $files = $fileQuery
            ->whereIn('id', $parameters['files'])
            ->get();

        DB::transaction(function () use ($fileQuery, $parameters) {

            Fileable::query()
                ->whereIn('file_id', $parameters['files'])
                ->delete();

            $fileQuery
                ->whereIn('id', $parameters['files'])
                ->delete();
        });

        // TODO : Fire a job to update the cache

        if (isset($parameters['is_force_delete'])) {
            Storage::delete(
                $files->pluck('path')->toArray()
            );
        }

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
