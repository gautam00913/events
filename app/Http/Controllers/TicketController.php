<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelQRCode\Facades\QRCode;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        
        $ticketFind = Ticket::where(
            'name', $request->name)->first();
        if ($ticketFind) {
        return response()->json([
            'ticket' => $ticketFind,
            'exist' => 1
        ]);

        } else {
            $ticket = Ticket::create([
                'name' => $request->name
            ]);
            return response()->json([
                'ticket' => $ticket,
                'exist' => 0
            ]);

        }
        

    }

    public function create(Request $request)
    {
        return view('events.ticket', ['i' => $request->query('id'), 'tickets' => Ticket::all()]);
    }

    public function buy(Request $request)
    {
        if(!$request->payment_id) return back()->with('toast', [
                                                       'type' => 'fail',
                                                       'message' => "Veillez d'abord procéder au paiement"
                                                    ]);
        $tickets_id = json_decode($request->query('tickets_id'));
        $tickets_place = json_decode($request->query('tickets_place'));
        $event = Event::find($request->event_id);

        $tickets = $event->tickets()->whereIn('event_ticket.id', $tickets_id)->get();
        foreach($tickets as $key => $ticket)
        {
            $place = intval($tickets_place[$key]);
            $user = auth()->user();
            $user->participations()->attach($event->id, [
                'event_ticket_id' => $ticket->pivot->id,
                'number_place' => $place,
                'total_amount' => $ticket->pivot->price * $place,
                'reserve_at' => now(),
                'payment_id' => $request->payment_id
            ]);
         
            DB::table('event_ticket')
                ->where('id', $ticket->pivot->id)
                ->update([
                    'remaining_place' => $ticket->pivot->remaining_place - $place
                ]);
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => "Achat de billets effectué avec succès.\n Consultez votre boîte mail pour télécharger votre billet ou visitez votre profile"
        ]);
    }

    public function pdf()
    {
        $qrcode = 'qrcodes/qrcode.png';
        QRCode::url(route('home'))->setMargin(1)->setOutfile(public_path($qrcode))->png();
        $pdf = Pdf::loadView('tickets.pdf', [
            'qrcode' => $qrcode
        ]);
        $pdf->setPaper('a6', 'landscape');
        return $pdf->stream();
    }
}
