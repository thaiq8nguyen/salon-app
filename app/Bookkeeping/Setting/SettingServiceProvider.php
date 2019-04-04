<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-13
 * Time: 14:25
 */

namespace App\Bookkeeping\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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
            'App\Bookkeeping\Setting\SettingInterface',
            'App\Bookkeeping\Setting\SettingRepository'
        );
    }
}
