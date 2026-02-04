<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PaymentStatusEnum;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'order_id',
        'status',
        'method',
        'amount',
        'meta'
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'method' => 'array',
        'amount' => 'decimal:2',
        'meta' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
