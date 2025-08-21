<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Mail\SendTicket;
use App\Mail\NewTicketBuyed;
use Illuminate\Http\Request;
use App\Events\TicketScanned;
use App\Services\PdfGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    public function buy(Request $request, PdfGenerator $pdfGenerator)
    {
        if(!$request->payment_id) return back()->with('toast', [
                                                       'type' => 'fail',
                                                       'message' => "Veillez d'abord procéder au paiement"
                                                    ]);
        $tickets_id = json_decode($request->query('tickets_id'));
        $tickets_place = json_decode($request->query('tickets_place'));
        $event = Event::with('user')->find($request->event_id);

        $tickets = $event->tickets()->whereIn('event_ticket.id', $tickets_id)->get();
        $tickets_path = [];
        $tickets_buyed = [];
        $total_paid = 0;
        foreach($tickets as $key => $ticket)
        {
            $place = intval($tickets_place[$key]);
            $reserve_at = now();
            $total_amount = $ticket->pivot->price * $place;
            $user = auth()->user();
            try{
                $user->participations()->attach($event->id, [
                    'event_ticket_id' => $ticket->pivot->id,
                    'number_place' => $place,
                    'total_amount' => $total_amount,
                    'reserve_at' => $reserve_at,
                    'payment_id' => $request->payment_id
                ]);
                $done = true;
            }catch(\Exception $e){
                Log::error("ERROR DURING PAYMENT SAVING :". $e->getMessage());
                $done = false;
            }
         
            if($done){
                DB::table('event_ticket')
                    ->where('id', $ticket->pivot->id)
                    ->update([
                        'remaining_place' => $ticket->pivot->remaining_place - $place
                    ]);
    
                //generate ticket pdf
                $tickets_path[] = $pdfGenerator->eventTicket($event, $ticket, $place, $user->name, $user->id, $reserve_at);
                $tickets_buyed[] = [
                    'ticket_id' =>$ticket->id,
                    'ticket_name' =>$ticket->name,
                    'ticket_price' =>$ticket->pivot->price,
                    'number_place' =>$place,
                    'total_amount' =>$total_amount,
                ];
                $total_paid += $total_amount;
            }

        }
        if($total_paid){
            try{
                //sending email to user with his tickets
                Mail::to($user->email)->send(new SendTicket($user, $event, $total_amount, $tickets_path));
            }catch(\Exception $e){
                Log::error("ERROR :". $e->getMessage());
            }
            try{
                //sending mail to the organizer
                Mail::to($event->user->email)->send(new NewTicketBuyed($event,$user, $tickets_buyed, $total_paid));
            }catch(\Exception $e){
                Log::error("ERROR :". $e->getMessage());
            }
          
            return back()->with('toast', [
                'type' => 'success',
                'message' => "Achat de billets effectué avec succès.\n Consultez votre boîte mail pour télécharger votre billet ou visitez votre <a href='". route('dashboard')."' class='underline'>tableau de bord</a>"
            ]);
        }
        return back()->with('toast', [
                'type' => 'fail',
                'message' => "Echec de l'opération.\n Veuillez réessayer!"
            ]);
    }

    public function status(string $ticket)
    {
        $tab = explode('-', $ticket);
        $event = Event::with(['user', 'participants', 'tickets'])->find($tab[2]);
        //confirm the originality of the identifiants given in the url
        if(!$event) return abort(404);
        if($event->user->id !== auth()->user()->id) return abort(403);
        $buyer = $event->participants->where('id', $tab[4])->first();
        $ticket = $event->tickets->where('id', $tab[3])->first();
        if(!$buyer || !$ticket) return abort(404);
        $buyer_ticket = $buyer->pivot->ticket;
        
        if(!$buyer->pivot->scanned && $buyer_ticket->id === $ticket->id)
        {
            $scanned_at = now();
            //change status to scanned and confirm validity of the ticket
            $buyer->participations()->updateExistingPivot($event->id, [
                'scanned' => 1,
                'scanned_at' => $scanned_at,
            ]);
            event(new TicketScanned($event, $ticket, $buyer, $scanned_at->format('d/m/Y \à H:i')));
        }
        return view('tickets.status', compact('event', 'ticket', 'buyer', 'buyer_ticket'));
    }

    public function download(PdfGenerator $pdfGenerator, string $ticket)
    {
        $file = public_path('tickets/'. $ticket. '.pdf');
        if(file_exists($file))
        {
            return response()->download($file, $ticket. '.pdf');
        }
        //else generate another ticket
        $tab = explode('-', $ticket);
        $event = Event::with(['user', 'participants', 'tickets'])->find($tab[2]);
        if($event)
        {
            $buyer = $event->participants->where('id', $tab[4])->first();
            $event_ticket = $event->tickets->where('id', $tab[3])->first();
            if($buyer && $event_ticket)
            {
                $file = $pdfGenerator->eventTicket($event, $event_ticket, $buyer->pivot->number_place, $buyer->name, $buyer->id, $buyer->pivot->reserve_at);
                if(file_exists($file))
                {
                    return response()->download($file, $ticket. '.pdf');
                }
            }
        }
        return back();
    }
}