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

        $updates = $items->map(function ($item) use ($order) {
            return ['id' => $item->id, 'sold' => true, 'order_id' => $order->id, 'price' => $order->variations->firstWhere('id', $item->variation_id)->price];
        });

        Item::updateValues($updates->toArray());
    }
}
