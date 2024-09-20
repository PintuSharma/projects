<?php

namespace App\Providers;

use App\Interfaces\MediaRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\ProjectRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Repositories\ProjectRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class,ProjectRepository::class);
        $this->app->bind(MediaRepositoryInterface::class,MediaRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
