<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use App\Events\OrderStatusChanged;
use App\Services\SMSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCorrespondingMessage
{
    /**
     * @var SMSService
     */
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SMSService $service)
    {
        //
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatusChanged $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        if (($event->oldStatus != $event->newStatus) && ($event->newStatus == OrderStatus::CANCELED)) {
            $this->service->send($event->order->user->mobile, "{$event->order->user->name}", 99642);
        }
    }
}
