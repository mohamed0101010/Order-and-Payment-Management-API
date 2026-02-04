<?php

namespace App\Http\Requests\V1\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\PaymentGatewayRegistry;

class ProcessPaymentRequest extends FormRequest
{

public function rules(): array
{
    return [
        'method' => [
            'required',
            'string',
            Rule::in(
                PaymentGatewayRegistry::where('enabled', true)->pluck('key')->map(fn($k) => strtolower($k))->toArray()
            ),
        ],
        'amount' => ['required', 'numeric', 'min:0.01'],
        'payload' => ['nullable', 'array'],
    ];
}

}
