<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Repositories\V1\Order\MysqlOrderRepository;
use App\Repositories\V1\Payment\PaymentRepositoryInterface;
use App\Repositories\V1\Payment\MysqlPaymentRepository;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, MysqlOrderRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, MysqlPaymentRepository::class);
    }
}
