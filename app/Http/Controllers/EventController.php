<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Pipes\Events\Event as EventPipe;
use App\Pipes\Events\Search;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' =>['create', 'store', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events= app(Pipeline::class)->send(Event::where('starts_at', '>=', now())
        ->with(['user', 'tags', 'tickets']))
        ->through([
            EventPipe::class,
            Search::class,
        ])->thenReturn()
                      ->orderBy('starts_at')
                      ->paginate(9);
      
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tickets = Ticket::all();
       return view('events.create', compact('tickets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
       $image = null;
      // dd($request->image, $_FILES['image']);
       if($request->image)
       {
            $image = $request->image->store('public/flyers');
       }
       $user = auth()->user();
       $event= $user->events()->create([
        'title' => $request->title,
        'content' => $request->content,
        'slug' => str($request->title)->slug(),
        'premium' => $request->filled('premium'),
        'starts_at' => $request->starts_at,
        'ends_at' => $request->ends_at,
        'image' => $image,
       ]);
       for($i = 0; $i< count($request->ticket_name); $i++)
       {
            $event->tickets()->attach($request->ticket_name[$i],
            [
                'price' => $request->ticket_price[$i],
                'total_place' => $request->ticket_place[$i],
                'remaining_place' => $request->ticket_place[$i],
            ]
        );
       }
       $tags= explode(',', $request->tags);
       foreach ($tags as $key => $inputTag) {
        $inputTag= trim($inputTag);
        $tag= Tag::firstOrCreate([
            'slug' => str($inputTag)->slug()
        ],[
            'name' => $inputTag
        ]);

        $event->tags()->attach($tag->id);
       }
       return redirect()->route('events.index')->with('toast', [
                                                        'type' => 'success',
                                                        'message' => "Evènement créé avec succès"
                                                    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if($event->user_id !== auth()->user()->id) return abort(404);
        $tickets = Ticket::all();
        return view('events.edit', compact('event', 'tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        if($event->user_id !== auth()->user()->id) return abort(404);
        $image = null;
        $tab = [];
       if($request->image)
       {
            $image = $request->image->store('public/flyers');
            $tab['image'] = $image;
       }
        $event->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => str($request->title)->slug(),
            'premium' => $request->filled('premium'),
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
           ] + $tab 
        );
       $tickets = $event->tickets;
       $tickets_id = $tickets->pluck('id');

       for($i = 0; $i< count($request->ticket_name); $i++)
       {
            if ($tickets_id->contains($request->ticket_name[$i])) {
                $event->tickets()->updateExistingPivot($request->ticket_name[$i],[
                        'price' => $request->ticket_price[$i],
                        'total_place' => $request->ticket_place[$i],
                        'remaining_place' => $tickets->get($i)->pivot->remaining_place + ($request->ticket_place[$i] - $tickets->get($i)->pivot->total_place),
                ]);
            } else {
                $event->tickets()->attach($request->ticket_name[$i],[
                    'price' => $request->ticket_price[$i],
                    'total_place' => $request->ticket_place[$i],
                    'remaining_place' => $request->ticket_place[$i],
                ]);
            }
        
       }
       $tags= explode(',', $request->tags);
       $event_tags = [];
       foreach ($tags as $key => $inputTag) {
        $inputTag= trim($inputTag);
        $tag= Tag::firstOrCreate([
            'slug' => str($inputTag)->slug()
        ],[
            'name' => $inputTag
        ]);
        $event_tags[]= $tag->id;
    }
    $event->tags()->sync($event_tags);
       $request->session()->flash('toast', [
                                                        'type' => 'success',
                                                        'message' => "Evènement $event->title modifié avec succès"
                                                    ]);
        return response()->json(['updated' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->user_id !== auth()->user()->id) return abort(404);
        $event->delete();
        return back()->with('toast', [
            'type' => 'success',
            'message' => "Evènement supprimé avec succès"
        ]);
    }

    public function participations()
    {
        $user = auth()->user();
        return view('events.participated', [
            'participations' => $user->participations,
            'user' => $user
        ]);
    }
    public function participants(Event $event)
    {
        return view('events.participants', [
            'participants' => $event->participants,
        ]);
    }
    public function created()
    {
        
        return view('events.created', [
            'events' => app(Pipeline::class)
                        ->send(auth()->user()->events()->with(['tags', 'tickets']))
                        ->through([
                            EventPipe::class
                        ])
                        ->thenReturn()
                        ->orderByDesc('created_at')
                        ->paginate(9)
        ]);
    }
}
