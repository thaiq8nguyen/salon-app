<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Bookkeeping\PayPeriod\PayPeriodInterface;

class GeneratePayPeriods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:pay-periods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 2 pay period ahead of every month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(PayPeriodInterface $payPeriod)
    {
        $payPeriod->generatePayPeriods();
    }
}
