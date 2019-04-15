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

    public $squareReceipt;
    public $technicianSales;
    public $summary;

    public function __construct($squareReceipt, $technicianSales, $summary)
    {
        $this->squareReceipt = $squareReceipt;
        $this->technicianSales =  $technicianSales;
        $this->summary = $summary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $saleDate = Carbon::createFromFormat('Y-m-d', $this->squareReceipt->date)->format('m/d/Y');
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Sugar Nails sale summary for '.$saleDate)
            ->view('emails.technician-sales.added');
    }
}
