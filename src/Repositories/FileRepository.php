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
        $parameters['extension'] = $parameters['file']->extension();

        $parameters['path'] = Storage::putFile(
            now()->format('Y/m/d'),
            $parameters['file'],
            'public'
        );

        if (!$parameters['path']) {
            throw ValidationException::withMessages([
                'file' => [__('messages::messages.not_enough_space')]
            ]);
        }

        return $this->file
            ->query()
            ->create($parameters);
    }

    public function delete(array $parameters): bool
    {
        $filesPath = File::query()
            ->whereIn('id', $parameters['files'])
            ->get(['path'])
            ->toArray();

        DB::beginTransaction();

        Fileable::query()
            ->whereIn('file_id', $parameters['files'])
            ->delete();

        if (
            isset($parameters['is_force_delete'])
            && $parameters['is_force_delete']
        ) {
            File::query()
                ->whereIn('id', $parameters['files'])
                ->delete();

            Storage::delete($filesPath);
        }

        DB::commit();

        // TODO : Fire a job to update the cache

        return true;
    }

    public function attach(array $parameters): bool
    {
        return Fileable::query()
            ->insert(
                $this->makeDataToAttach($parameters)
            );
    }

    public function detach(array $parameters): bool
    {
        return Fileable::query()
            ->where('file_id', $parameters['file_id'])
            ->where('fileable_type', $parameters['model'])
            ->whereIn('fileable_id', $parameters['model_ids'])
            ->delete();
    }

    public function applyFilters(Builder $query = null, array $parameters = []): Builder
    {
        if (isset($parameters['path'])) {
            $query->where('path', $parameters['path']);
        }

        return parent::applyFilters($query, $parameters);
    }

    protected function makeDataToAttach(array $parameters): array
    {
        return collect($parameters['model_ids'])->map(function ($modelId) use ($parameters) {
            return [
                'file_id' => $parameters['file_id'],
                'fileable_type' => $parameters['model'],
                'fileable_id' => $modelId,
            ];
        })->toArray();
    }
}
