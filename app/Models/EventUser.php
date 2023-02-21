<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    public $casts = [
        'reserve_at' => 'datetime'
    ];
    protected $fillable = ['event_ticket_id', 'number_place', 'total_amount', 'reserve_at', 'payment_id', 'scanned'];

    public function getTicketAttribute()
    {
        return DB::table('event_ticket')
                ->join('tickets', 'tickets.id', '=', 'event_ticket.ticket_id')
                ->where('event_ticket.id', $this->event_ticket_id)
                ->select('tickets.id', 'tickets.name', 'event_ticket.price')
                ->first();
    }
}
