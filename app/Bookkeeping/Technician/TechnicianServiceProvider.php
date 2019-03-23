<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-05
 * Time: 11:48
 */

namespace App\Bookkeeping\Technician;

use Illuminate\Support\ServiceProvider;

class TechnicianServiceProvider extends ServiceProvider
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
            'App\Bookkeeping\Technician\TechnicianInterface',
            'App\Bookkeeping\Technician\TechnicianRepository'
        );
    }
}
