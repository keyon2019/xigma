<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateOrderPaymentStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order;
        $order->update(['paid' => true, 'status' => OrderStatus::INSPECTING]);
    }
}
