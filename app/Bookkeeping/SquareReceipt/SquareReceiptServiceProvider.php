<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-13
 * Time: 14:25
 */

namespace App\Bookkeeping\SquareReceipt;

use Illuminate\Support\ServiceProvider;

class SquareReceiptServiceProvider extends ServiceProvider
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
            'App\Bookkeeping\SquareReceipt\SquareReceiptInterface',
            'App\Bookkeeping\SquareReceipt\SquareReceiptRepository'
        );
    }
}
