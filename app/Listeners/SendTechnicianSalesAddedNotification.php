<?php

namespace App\Listeners;

use App\Events\TechnicianSalesAddedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\TechnicianSalesAddedMail;

class SendTechnicianSalesAddedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TechnicianSalesAddedEvent  $event
     * @return void
     */
    public function handle(TechnicianSalesAddedEvent $event)
    {
        Mail::to('discoverylight@yahoo.com')->send(new TechnicianSalesAddedMail($event->technicianSales));

    }
}
