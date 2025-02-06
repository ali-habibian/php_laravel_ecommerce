<?php

namespace App\Providers;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        AliasLoader::getInstance()->alias('Cart', CartFacade::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->is('admin-panel/*')) {
            Paginator::useBootstrap();
        } else {
            Paginator::defaultView('home.sections.pagination');
        }
    }
}
