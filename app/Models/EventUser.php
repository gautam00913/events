<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    public $casts = [
        'reserve_at' => 'datetime'
    ];

    public function getTicketAttribute()
    {
        return DB::table('event_ticket')
                ->join('tickets', 'tickets.id', '=', 'event_ticket.ticket_id')
                ->where('event_ticket.id', $this->ticket_id)
                ->select('tickets.id', 'tickets.name', 'event_ticket.price')
                ->first();
    }
}
