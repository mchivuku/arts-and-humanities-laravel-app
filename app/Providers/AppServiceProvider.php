<?php

namespace ArtsAndHumanities\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // clockwork helper function on test
         if ($this->app->environment('webservet')) {
           include_once app_path().'/start/webservet.php';
         }


    }
}
