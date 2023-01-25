<?php

namespace App\Pipes\Events;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                        ->orWhereIn('id', DB::table('event_tag')->select('event_id')
                                            ->whereIn('tag_id', Tag::select('id')
                                                                ->where('name', 'like', "%{$search}%")
                                        )
                        )
                        ->orWhereIn('user_id', $users_id);
        });
        return $next($query);
    }
}