<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
}
