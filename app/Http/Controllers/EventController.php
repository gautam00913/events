<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Event;
use App\Models\Ticket;
use App\Pipes\Events\Search;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

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
    public function store(Request $request)
    {
       $request->validate([
        'title' => 'required|string|min:10|max:100',
        'content' => 'required|string',
        'starts_at' => 'required|date',
        'ends_at' => 'nullable|date',
        'tags' => 'nullable|string',
        'image' => 'nullable|image',
       ]);
     
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
