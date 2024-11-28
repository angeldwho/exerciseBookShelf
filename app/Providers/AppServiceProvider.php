<?php

namespace App\Providers;

use App\Interfaces\IRepositories\AuthorRepositoryInterface;
use App\Interfaces\IRepositories\BookRepositoryInterface;
use App\Interfaces\IRepositories\CategoryRepositoryInterface;
use App\Interfaces\IRepositories\RepositoryInterface;
use App\Repositories\AuthorRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class,BookRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class,AuthorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class,CategoryRepository::class);
        $this->app->bind(RepositoryInterface::class,BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
