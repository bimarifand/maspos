<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
            Route::middleware('web')->group(function () {
                if (auth()->check() && request()->is('dashboard/login')) {
                    return redirect('/');
                }
            });
        
    }
}
