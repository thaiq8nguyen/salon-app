<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TechnicianSalesAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $technicianSales;


    /**
     * TechnicianSalesAddedMail constructor.
     * @param $technicianSales
     */
    public function __construct($technicianSales)
    {
        $this->technicianSales =  $technicianSales;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $technicianSales = $this->technicianSales;
        $saleDate = Carbon::createFromFormat('Y-m-d', $technicianSales[0]->sale->date)->format('m/d/Y');
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Technician Sales for '. $saleDate)
            ->view('emails.technician-sales.added');
    }
}
