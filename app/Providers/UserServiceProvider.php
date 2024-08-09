<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User\Repositories\UserRepository;
use App\User\Repositories\Contracts\UserRepositoryInterface;
use App\User\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interface to implementation
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind('UserService', function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
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
