<?php

namespace App\Listeners;

use App\Events\ProductIsNowAvailable;
use App\Models\Reminder;
use App\Services\SMSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAvailabilitySubscribers
{
    protected $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SMSService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(ProductIsNowAvailable $event)
    {
        //todo send SMS
        Reminder::whereVariationId($event->variation->id)->delete();
    }
}
