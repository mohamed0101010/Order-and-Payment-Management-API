<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'order_id' => $this->order_id,
    
            'status' => $this->status instanceof \BackedEnum ? $this->status->value : $this->status,
            'method' => $this->method instanceof \BackedEnum ? $this->method->value : $this->method,
    
            'amount' => (float) $this->amount,
            'meta' => $this->meta ?? [],
    
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
    
}
