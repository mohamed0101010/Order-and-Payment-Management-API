<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Order\CreateOrderRequest;
use App\Http\Requests\V1\Order\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Actions\V1\Order\CreateOrderAction;
use App\Actions\V1\Order\UpdateOrderAction;
use App\Actions\V1\Order\DeleteOrderAction;
use App\DTOs\V1\Order\CreateOrderDTO;
use App\DTOs\V1\Order\UpdateOrderDTO;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly CreateOrderAction $createOrder,
        private readonly UpdateOrderAction $updateOrder,
        private readonly DeleteOrderAction $deleteOrder,
    ) {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $perPage = (int) $request->query('per_page', 15);

        $paginated = $this->orders->paginate($status, $perPage);

        return api_response(OrderResource::collection($paginated), 200, 'Orders fetched.');
    }

    public function store(CreateOrderRequest $request)
    {
        $dto = new CreateOrderDTO(
            userId: $request->user()->id,
            customerName: $request->string('customer_name')->toString(),
            customerEmail: $request->string('customer_email')->toString(),
            status: (string) $request->input('status', 'pending'),
            items: (array) $request->input('items')
        );

        $order = $this->createOrder->execute($dto);

        return api_response(new OrderResource($order), 201, 'Order created.');
    }

    public function show(Order $order)
    {
        $order->load(['items','payments']);
        return api_response(new OrderResource($order), 200, 'Order details.');
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $dto = new UpdateOrderDTO(
            customerName: $request->input('customer_name'),
            customerEmail: $request->input('customer_email'),
            status: $request->input('status'),
            items: $request->input('items')
        );

        $updated = $this->updateOrder->execute($order, $dto);

        return api_response(new OrderResource($updated), 200, 'Order updated.');
    }

    public function destroy(Order $order)
    {
        try {
            $this->deleteOrder->execute($order);
            return api_response([], 200, 'Order deleted.');
        } catch (\App\Exceptions\Orders\OrderCannotBeDeletedException $e) {
            return api_response([], 409, $e->getMessage());
        }
    }
}
