<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventUser;
use App\Mail\NewTicketBuyed;
use App\Pipes\Events\Search;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class StaticPageController extends Controller
{
    public function home()
    {
        $events = app(Pipeline::class)->send(
            Event::where('starts_at', '<=', now()->addMonth(3))
                    ->where(function($query){
                        return $query->where('starts_at', '>=', now())
                                    ->orWhere('ends_at', '>=', now());
                    })
        )
        ->through([
            Search::class,
        ])
        ->thenReturn()
        ->orderBy('starts_at')
        ->paginate(6);

        return view('welcome', compact('events'));
    }

    public function dashboard()
    {
        $user = User::withCount(['events', 'participations'])
                ->withSum('participations', 'event_user.total_amount')
                ->withSum('transactions', 'refunded_amount')
                ->with('events')
                ->find(auth()->user()->id);
        $total_amount = EventUser::whereIn('event_id', $user->events->pluck('id')->all())->sum('total_amount');
        return view('dashboard', ['user' => $user, 'total_amount' => $total_amount]);
    }

    public function email()
    {
        $event = Event::with('user')->find(1);
        $user = User::find(1);
        $total_amount = 24000;
        $tickets_buyed[] = [
            'ticket_id' =>1,
            'ticket_name' =>'PASS',
            'ticket_price' =>12000,
            'number_place' =>2,
            'total_amount' =>$total_amount,
        ];
        return new NewTicketBuyed($event, $user, $tickets_buyed, $total_amount);
        
    }
}
