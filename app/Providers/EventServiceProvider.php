<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Events\OrderStatusChanged;
use App\Events\ProductIsNowAvailable;
use App\Listeners\AddItemsToOrder;
use App\Listeners\NotifyavailabilitySubscribers;
use App\Listeners\NotifyRetailers;
use App\Listeners\SendCorrespondingMessage;
use App\Listeners\SendNotificationToAdmin;
use App\Listeners\TransferCartFromSessionToDB;
use App\Listeners\UpdateInventory;
use App\Listeners\UpdateOrderPaymentStatus;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            TransferCartFromSessionToDB::class
        ],
        OrderPaid::class => [
            UpdateOrderPaymentStatus::class, UpdateInventory::class,
//            AddItemsToOrder::class, NotifyRetailers::class
        ],
        OrderStatusChanged::class => [
            UpdateInventory::class, SendNotificationToAdmin::class, SendCorrespondingMessage::class,
        ],
        ProductIsNowAvailable::class => [
            NotifyAvailabilitySubscribers::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
