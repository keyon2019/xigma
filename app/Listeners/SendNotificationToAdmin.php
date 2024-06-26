<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use App\Enum\Role;
use App\Events\OrderStatusChanged;
use App\Models\User;
use App\Notifications\OrderPlaced;
use App\Notifications\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAdmin
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
     * @param  OrderStatusChanged $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        if (($event->newStatus != $event->oldStatus) && ($event->newStatus == OrderStatus::PREPARING)) {
            Notification::send(User::queryHasRole(Role::STOCK)->get(), new OrderPlaced($event->order));
        }
    }
}
