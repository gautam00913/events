<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withPivot(['price', 'total_place', 'remaining_place']);
    }
}
