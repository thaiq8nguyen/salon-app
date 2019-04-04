<?php

namespace App\Bookkeeping\PayPeriod;

use Illuminate\Support\ServiceProvider;

class PayPeriodServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Bookkeeping\PayPeriod\PayPeriodInterface',
            'App\Bookkeeping\PayPeriod\PayPeriodRepository'
        );
    }

}
