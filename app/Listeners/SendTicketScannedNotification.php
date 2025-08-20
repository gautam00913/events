<?php

namespace App\Listeners;

use App\Events\TicketScanned;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketScannedNotification;

class SendTicketScannedNotification
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
     * @param  \App\Events\TicketScanned  $event
     * @return void
     */
    public function handle(TicketScanned $event)
    {
        try{
            Mail::to($event->buyer->email)->send(new TicketScannedNotification($event->event, $event->ticket, $event->buyer, $event->scanned_at));
        }catch(\Exception $e){
           Log::error("ERROR :". $e->getMessage());
        }
    }
}