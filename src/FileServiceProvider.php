<?php

namespace Celysium\File;

use Celysium\File\Repositories\FileRepository;
use Celysium\File\Repositories\FileRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'messages');
    }
}
