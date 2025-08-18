<?php

namespace App\Listeners;

use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeMail
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
     * @param  \App\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        try{
            Mail::to($event->user->email)->send(new WelcomeUser($event->user, $event->user->hashPassword));
        }catch(\Exception $e){
           Log::error("ERROR :". $e->getMessage());
        }
    }
}