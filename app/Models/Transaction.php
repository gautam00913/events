<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'user_id', 'fees_amount', 'refunded_amount',
     'account_holder', 'account_number', 'account_provider', 'initiate_at', 'refunded_at' ];

    public $timestamps = false;
    
    public function initiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
