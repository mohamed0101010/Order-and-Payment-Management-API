<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'status' => (string) $this->status->value,
            'total' => (float) $this->total,

            'items' => $this->whenLoaded('items', fn () =>
                $this->items->map(fn ($i) => [
                    'id' => $i->id,
                    'product_name' => $i->product_name,
                    'quantity' => (int) $i->quantity,
                    'price' => (float) $i->price,
                    'line_total' => (float) $i->line_total,
                ])
            ),

            'payments' => $this->whenLoaded('payments', fn () =>
                $this->payments->map(fn ($p) => [
                    'id' => $p->id,
                    'payment_id' => $p->payment_id,
                    'status' => (string) $p->status->value,
                    'method' => (string) $p->method->value,
                    'amount' => (float) $p->amount,
                ])
            ),

            'created_at' => $this->created_at,
        ];
    }
}
