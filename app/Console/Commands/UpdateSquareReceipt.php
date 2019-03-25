<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Bookkeeping\SquareReceipt\SquareReceiptInterface;

class UpdateSquareReceipt extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:square-receipt {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update square receipt tables using Square API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle(SquareReceiptInterface $squareReceipt)
    {

        if (is_null($this->argument('date'))) {
            $date = Carbon::now()->format('Y-m-d');
        } else {
            $date = $this->argument('date');
        }

        $squareReceipt->updateSquareReceipt($date);
    }
}
