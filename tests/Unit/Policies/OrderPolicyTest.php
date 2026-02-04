<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Policies\OrderPolicy;
use App\Models\User;
use App\Models\Order;
use Mockery;

class OrderPolicyTest extends TestCase
{
    private OrderPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new OrderPolicy();
    }

    public function test_owner_can_view_update_and_delete_when_no_payments(): void
    {
        $user = new User();
        $user->id = 1;

        $order = Mockery::mock(Order::class)->makePartial();
        $order->user_id = 1;
        $order->shouldReceive('payments->exists')->andReturn(false);

        $this->assertTrue($this->policy->view($user, (object)$order));
        $this->assertTrue($this->policy->update($user, (object)$order));
        $this->assertTrue($this->policy->delete($user, (object)$order));
    }

    public function test_non_owner_cannot_view_update_or_delete(): void
    {
        $user = new User();
        $user->id = 2;

        $order = Mockery::mock(Order::class)->makePartial();
        $order->user_id = 1;
        $order->shouldReceive('payments->exists')->andReturn(false);

        $this->assertFalse($this->policy->view($user, (object)$order));
        $this->assertFalse($this->policy->update($user, (object)$order));
        $this->assertFalse($this->policy->delete($user, (object)$order));
    }

    public function test_owner_cannot_delete_when_payments_exist(): void
    {
        $user = new User();
        $user->id = 1;

        $order = Mockery::mock(Order::class)->makePartial();
        $order->user_id = 1;
        $order->shouldReceive('payments->exists')->andReturn(true);

        $this->assertTrue($this->policy->delete($user, (object)$order));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
