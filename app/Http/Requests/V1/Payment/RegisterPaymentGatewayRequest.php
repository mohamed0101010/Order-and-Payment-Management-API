<?php

namespace App\Http\Requests\V1\Payment;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPaymentGatewayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string|unique:payment_gateways,key',
            'class' => 'nullable|string',
            'enabled' => 'boolean',
            'config' => 'array',
        ];
    }
}
