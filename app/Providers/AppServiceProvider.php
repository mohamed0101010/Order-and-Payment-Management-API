<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use App\Services\Payment\Gateways\PaymentGatewayManager;
use App\Services\Payment\Gateways\Gateways\CreditCardGateway;
use App\Services\Payment\Gateways\Gateways\DynamicGateway;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DynamicGateway::class, function ($app, $params) {
            return new DynamicGateway(
                $app->make(\Illuminate\Contracts\Config\Repository::class),
                $params['overrideConfig'] ?? []
            );
        });
    
        $this->app->bind(PaymentGatewayManager::class, function ($app) {
            $instances = [];
    
            try {
                $registeredGateways = $app->make(\App\Models\PaymentGatewayRegistry::class)
                    ->where('enabled', true)
                    ->get();
    
                foreach ($registeredGateways as $gateway) {
                    if (!empty($gateway->class) && class_exists($gateway->class)) {
                        $instances[] = $app->make($gateway->class);
                    } else {
                        $instances[] = $app->make(DynamicGateway::class, [
                            'overrideConfig' => array_merge(
                                ['key' => $gateway->key],
                                $gateway->config ?? []
                            ),
                        ]);
                    }
                }
    
                if (!empty($instances)) {
                    return new PaymentGatewayManager($instances);
                }
            } catch (\Exception $e) {
            }
    
            $enabled = config('payment_gateways.enabled', []);
            foreach ($enabled as $key) {
                if ($key === 'credit_card') {
                    $instances[] = $app->make(\App\Services\Payment\Gateways\Gateways\CreditCardGateway::class);
                } else {
                    $instances[] = $app->make(DynamicGateway::class, [
                        'overrideConfig' => ['key' => $key],
                    ]);
                }
            }
    
            return new PaymentGatewayManager($instances);
        });
    }
    

    public function boot(): void
    {
        //
    }
}
