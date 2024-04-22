<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('modules', auth()->user()->modules);
//                $view->with('notifications', auth()->user()->notifications);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()){
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
