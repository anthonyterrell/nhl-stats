<?php

namespace App\Providers;

use App\Api\NHL\NHLApi;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer('welcome', function (View $view) {
            $view->with('schedule', app(NHLApi::class)->upcomingScheduleFor('CHI'));

            $view->with('standings', app(NHLApi::class)->standings());
        });
    }
}
