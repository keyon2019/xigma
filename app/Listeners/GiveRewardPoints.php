<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use App\Events\OrderPaid;
use App\Models\Point;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GiveRewardPoints
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
    public function handle(OrderPaid $event)
    {
        $points = $event->order->points;

        if ($points <= 0) {
            return;
        }

        $user = $event->order->user;

        $user->total_points += $points;

        $user->save();

        Point::create([
            'user_id' => $user->id,
            'amount' => $points,
            'description' => "بابت سفارش شماره {$event->order->id}"
        ]);
    }
}
