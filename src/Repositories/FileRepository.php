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

        return $this->file
            ->query()
            ->create($parameters);
    }

    public function delete(array $parameters): bool
    {
        DB::beginTransaction();

        $paths = File::query()
            ->whereIn('id', $parameters['files'])
            ->get(['path'])
            ->toArray();

        Fileable::query()
            ->whereIn('file_id', $parameters['files'])
            ->delete();

        if (!empty($parameters['is_force_delete'])) {
            File::query()
                ->whereIn('id', $parameters['files'])
                ->delete();

            $result = Storage::delete($paths);

            if ($result) {
                DB::commit();
                //TODO : fire job to update cache
                return true;
            } else {
                DB::rollBack();
                return false;
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
