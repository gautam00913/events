<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function home()
    {
        $events = Event::where('starts_at', '<=', now()->addMonth(3))
                    ->where(function($query){
                        return $query->where('starts_at', '>=', now())
                                    ->orWhere('ends_at', '>=', now());
                    })
                    ->paginate(6);
        return view('welcome', compact('events'));
    }
}
