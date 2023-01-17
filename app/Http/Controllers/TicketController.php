<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

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
        return view('events.ticket', ['i' => $request->query('id')]);
    }
}
