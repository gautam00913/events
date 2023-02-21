<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public User $buyer,
        public Event $event,
        public float $total_amount,
        public array $tickets
    )
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $config = $this->markdown('emails.send-ticket')
                    ->subject("Achat de billets pour {$this->event->title}");
        foreach($this->tickets as $ticket)
        {
            $config->attach($ticket, [
                'as' => basename(public_path($ticket)),
                'mime' => 'application/pdf'
            ]);
        }

        return $config;
    }
}
