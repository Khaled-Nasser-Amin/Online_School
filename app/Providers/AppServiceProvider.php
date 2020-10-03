<?php

namespace App\Providers;

use App\Traits\GetCurrentGuard;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    use GetCurrentGuard;
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

        view()->composer('*', function($view)
        {
            $view->with(['user' => auth()->guard($this->getGuard())->user()]);
        });
    }
}
