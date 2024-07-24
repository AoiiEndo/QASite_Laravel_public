<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

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
    public function boot()
    {
<<<<<<< HEAD
       if (App::environment('production','staging')) {
=======
        if (App::environment('production','staging')) {
>>>>>>> 6c453e3714931fc77c440fc28035dbbf9a0ffa22
            URL::forceScheme('https');
        }
    }
}
