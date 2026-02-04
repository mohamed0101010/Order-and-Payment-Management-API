<?php

namespace App\Http\Requests\V1\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['required','string','max:255'],
            'customer_email' => ['required','email','max:255'],
            'status' => ['sometimes', Rule::in(['pending','confirmed','cancelled'])],
            'items' => ['required','array','min:1'],
            'items.*.product_name' => ['required','string','max:255'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.price' => ['required','numeric','min:0.01'],
        ];
    }
}
