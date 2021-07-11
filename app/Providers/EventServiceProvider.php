<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Listeners\AddItemsToOrder;
use App\Listeners\TransferCartFromSessionToDB;
use App\Listeners\UpdateOrderPaymentStatus;
use Illuminate\Auth\Events\Login;
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
            UpdateOrderPaymentStatus::class, AddItemsToOrder::class
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
