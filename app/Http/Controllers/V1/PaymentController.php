<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Payment\ProcessPaymentRequest;
use App\Http\Requests\V1\Payment\RegisterPaymentGatewayRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Order;
use App\Models\PaymentGatewayRegistry;
use App\Repositories\V1\Payment\PaymentRepositoryInterface;
use App\Actions\V1\Payment\ProcessPaymentAction;
use App\DTOs\V1\Payment\ProcessPaymentDTO;
use App\Services\Payment\Gateways\GatewayFileGenerator;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentRepositoryInterface $payments,
        private readonly ProcessPaymentAction $processPayment
    ) {}

    public function process(ProcessPaymentRequest $request, Order $order)
    {
        $dto = new ProcessPaymentDTO(
            orderId: $order->id,
            method: $request->string('method')->toString(),
            amount: (float) $request->input('amount'),
            payload: (array) $request->input('payload', [])
        );

        try {
            $payment = $this->processPayment->execute($dto);
            return api_response(new PaymentResource($payment), 201, 'Payment processed.');
        } catch (\App\Exceptions\Payments\OrderNotConfirmedException $e) {
            return api_response([], 422, $e->getMessage());
        } catch (\App\Exceptions\Payments\UnsupportedPaymentGatewayException $e) {
            return api_response([], 422, $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $paginated = $this->payments->paginate($perPage);

        return api_response(PaymentResource::collection($paginated), 200, 'Payments fetched.');
    }

    public function orderPayments(Request $request, Order $order)
    {
        $perPage = (int) $request->query('per_page', 15);
        $paginated = $this->payments->forOrder($order->id, $perPage);

        return api_response(PaymentResource::collection($paginated), 200, 'Order payments fetched.');
    }

    public function registerGateway(RegisterPaymentGatewayRequest $request)
    {
        try {
            $key = $request->string('key')->toString();
            $classFromRequest = $request->input('class');
            
            $gatewayClass = null;
            
            if (!empty($classFromRequest)) {
                $gatewayClass = $classFromRequest;
            } else {
                $gatewayClass = GatewayFileGenerator::generate($key);
            }
            
            $gateway = PaymentGatewayRegistry::updateOrCreate(
                ['key' => $key],
                [
                    'class' => $gatewayClass,
                    'enabled' => $request->boolean('enabled', true),
                    'config' => $request->input('config', []),
                ]
            );

            return api_response($gateway, 201, 'Payment gateway registered successfully.');
        } catch (\Exception $e) {
            return api_response([], 500, 'Error registering gateway: ' . $e->getMessage());
        }
    }
}
