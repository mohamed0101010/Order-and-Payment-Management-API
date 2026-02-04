<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayRegistry extends Model
{
    protected $table = 'payment_gateways';
    protected $fillable = [
        'key',
        'class',
        'enabled',
        'config'];
    protected $casts = ['config' => 'array'];
}
