<?php

namespace App\Bookkeeping\TechnicianSale;

use Illuminate\Support\ServiceProvider;

class TechnicianSaleServiceProvider extends ServiceProvider
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
            'App\Bookkeeping\TechnicianSale\TechnicianSaleInterface',
            'App\Bookkeeping\TechnicianSale\TechnicianSaleRepository'
        );
    }
}
