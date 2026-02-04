<?php

namespace App\Exceptions\Payments;

use Exception;

class InvalidPaymentAmountException extends Exception
{
    protected $message = 'Payment amount does not match order total.';
}
