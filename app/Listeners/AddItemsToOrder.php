<?php

namespace App\Listeners;

use App\Models\Item;
use App\Services\ClosestItemFinderService;

class AddItemsToOrder
{
    private $closesItemFinderService;

    public function __construct(ClosestItemFinderService $closesItemFinderService)
    {
        $this->closesItemFinderService = $closesItemFinderService;
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

        $items = $this->closesItemFinderService->find($order->address_id, $order->variations, $order->cost_preference);

        Item::whereIn('id', $items->pluck('id'))->update([
            'order_id' => $order->id,
            'sold' => true
        ]);
    }
}
