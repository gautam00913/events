<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $casts = [
        'initiate_at' => 'datetime',
        'refunded_at' => 'datetime'
    ];
    protected $fillable = ['amount', 'fees_amount', 'refunded_amount',
     'account_holder', 'account_number', 'account_provider','refunded_at','initiate_at' ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->initiate_at = now();
            $model->user_id = auth()->user()->id;
        });
    }
    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
