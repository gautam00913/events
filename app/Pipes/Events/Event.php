<?php

namespace App\Pipes\Events;

class Event
{
    public function handle($query, \Closure $next)
    {
        $query->when(request()->has('event'), function($query){
            return $query->where('id', request()->query('event'))
                            ->orWhere('slug', request()->query('event'));
        });

        return $next($query);
    }
}