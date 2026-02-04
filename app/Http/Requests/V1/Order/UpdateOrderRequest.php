<?php

namespace App\Http\Requests\V1\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['sometimes','string','max:255'],
            'customer_email' => ['sometimes','email','max:255'],
            'status' => ['sometimes', Rule::in(['pending','confirmed','cancelled'])],
            'items' => ['sometimes','array','min:1'],
            'items.*.product_name' => ['required_with:items','string','max:255'],
            'items.*.quantity' => ['required_with:items','integer','min:1'],
            'items.*.price' => ['required_with:items','numeric','min:0.01'],
        ];
    }
}
