<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            static $user = null;
            static $resolved = false;

            if (!$resolved) {
                try {
                    $user = app(UserService::class)->getFirst();
                } catch (\Throwable) {
                    $user = null;
                }
                $resolved = true;
            }

            $view->with('user', $user);
        });
    }
}
