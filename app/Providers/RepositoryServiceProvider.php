<?php

namespace App\Providers;

use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\TodoRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\TodoRepository;
use App\Repositories\ItemRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
