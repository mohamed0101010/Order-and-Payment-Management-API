<?php

namespace App\Exceptions\Orders;

use RuntimeException;

class OrderCannotBeDeletedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Order cannot be deleted because it has associated payments.');
    }
}
