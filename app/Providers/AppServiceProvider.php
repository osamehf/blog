<?php

namespace App\Providers;

use App\Http\Contracts\CommentInterface;
use App\Http\Contracts\PostInterface;
use App\Http\Services\CommentService;
use App\Http\Services\PostService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(PostInterface::class, PostService::class);
        app()->singleton(CommentInterface::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
