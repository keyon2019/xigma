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
        $retailers = $order->retailers;
        Notification::send($retailers->pluck('user'), new RetailerOrderPlaced($order));
    }
}
