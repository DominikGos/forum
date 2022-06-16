<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('avatar', '/images/avatar.jpg');

        Blade::directive('redableDate', function ($date) {
            return "<?php
                echo $date
                    ? Carbon\Carbon::parse($date)->format('H:i  M d, Y ')
                    : null;
            ?>";
        });
    }
}
