<?php

namespace App\Providers;

use App\Project\Repositories\Contracts\ProjectRepositoryInterface;
use App\Project\Repositories\ProjectRepository;
use App\Project\Services\ProjectService;
use Illuminate\Support\ServiceProvider;


class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interface to implementation
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind('ProjectService', function ($app) {
            return new ProjectService($app->make(ProjectRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
