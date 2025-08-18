<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use LaravelQRCode\Facades\QRCode;

class PdfGenerator
{
    public function eventTicket(Event $event, Ticket $ticket, int $place_reserved, string $buyer_name, int $buyer_id, Carbon $reserve_at) : string
    {
        $name = '00-'. $event->id. '-'.$ticket->id. '-'. $buyer_id;
        $qrcode = "qrcodes/qrc-{$name}.png";
        $ticket_name = "tickets/tk-{$name}.pdf";
        $ticket_path= public_path().'/tickets/';
        $qrcode_path= public_path().'/qrcodes/';
        if (!file_exists($ticket_path)) {
            mkdir($ticket_path, 0777, true);
        }
        if (!file_exists($qrcode_path)) {
            mkdir($qrcode_path, 0777, true);
        }
        QRCode::url(route('tickets.status', ['ticket' => 'tk-'. $name]))->setMargin(1)->setOutfile(public_path($qrcode))->png();
        $pdf = Pdf::loadView('tickets.pdf', [
            'qrcode' => $qrcode,
            'event' => $event,
            'ticket' => $ticket,
            'name' => $name,
            'place_reserved' => $place_reserved,
            'buyer_name' => $buyer_name,
            'reserve_at' => $reserve_at,
        ]);
        $pdf->setPaper('a6', 'landscape')->save(public_path($ticket_name));
        if(file_exists(public_path($qrcode)))
            unlink(public_path($qrcode));
            
        return $ticket_name;
    }

}