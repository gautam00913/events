<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    protected $guarded= [];
    protected $casts=[
        'starts_at' =>'datetime',
        'ends_at' =>'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class)->withPivot(['id','price', 'total_place', 'remaining_place']);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(EventUser::class)->withPivot(['event_ticket_id', 'number_place', 'total_amount', 
                                                                                    'reserve_at', 'payment_id', 'scanned', 'scanned_at']);
    }

    public function getFormatTagsAttribute()
    {
        $tags='';
        $event_tags = $this->tags()->get();
        $event_tags_count = $event_tags->count();
        foreach ($event_tags as $key => $tag) {
            $tags .= $tag->name;
            if($event_tags_count > ($key +1)) $tags .= ', ';
        }
        return $tags;
    }
}