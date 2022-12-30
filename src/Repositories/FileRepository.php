<?php

namespace Celysium\File\Repositories;

use Celysium\File\Models\File;
use Celysium\File\Models\Fileable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{

    public function list(array $parameters): LengthAwarePaginator|Collection
    {
        $query = File::query();

        $query = $this->applyFilters($query, $parameters);

        if (isset($parameters['paginate']) && !empty($parameters['paginate'])) {
            return $query->paginate($parameters['paginate']);
        } else {
            return $query->get();
        }
    }

    public function store(array $parameters): Model|Builder
    {
        $parameters['path'] = Storage::putFile(now()->format('Y/m/d'), $parameters['file'], 'public');

        return File::query()
            ->create($parameters);
    }

    public function delete(array $parameters): bool
    {
        Fileable::query()
            ->whereIn('file_id', function ($query) use ($parameters) {
                $query->select('id')
                    ->from('files')
                    ->whereIn('id', $parameters['files'])
                    ->get();
            })->delete();

        File::query()
            ->whereIn('id', $parameters['files'])
            ->delete();

        // TODO : Fire a job to update the cache

        if (isset($parameters['from_storage'])) {
            Storage::delete($parameters);
        }

        return true;
    }

    protected function applyFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['id'])) {
            $query->whereIn('id', $filters['id']);
        }

        if (isset($filters['path'])) {
            $query->whereIn('path', $filters['path']);
        }

        return $query;
    }
}
