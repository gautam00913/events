<?php

namespace App\Pipes\Events;

use App\Models\User;

class Search
{
    public function handle($query, \Closure $next)
    {
        $search = request()->query('search');
        $query->when($search, function($query) use($search){
            $users_id = User::where('name', 'like', "%{$search}%")->get('id')->pluck('id')->all();
            return $query->where('title', "like", "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhereIn('user_id', $users_id);
        });
        return $next($query);
    }
}