<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use App\Enum\Role;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        Notification::send(User::whereIsAdmin(true)->get(), new OrderPlaced($order));
        $order->update(['paid' => true, 'status' => OrderStatus::INSPECTING]);
    }
}
