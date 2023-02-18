<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Notifications\RetailerOrderPlaced;
use Illuminate\Support\Facades\Notification;

class NotifyRetailers
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
     * @param  OrderPaid $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order;
        $users = $order->shippings()->with('stock.user')->get()->pluck('stock.user')->filter();
        Notification::send($users, new RetailerOrderPlaced($order));
    }
}
