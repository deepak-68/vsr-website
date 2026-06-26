<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\HomeController; // 👈 use your controller

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $controller = app(HomeController::class);
            $settings = $controller->getSystemSettings(); // 👈 API call
            $view->with('settings', $settings);
        });
    }
}