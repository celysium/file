<?php

namespace Celysium\File;

use Celysium\File\Repositories\FileServiceInterface;
use Celysium\File\Repositories\FileServiceRepository;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FileServiceInterface::class, FileServiceRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
