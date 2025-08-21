<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketScannedNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Event $event,
        public Ticket $ticket,
        public User $buyer,
        public string $scanned_at
    )
    {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ticket-scanned')
                    ->subject("{$this->event->title} : Confirmation de scannage de votre billet éléctronique");
    }
}