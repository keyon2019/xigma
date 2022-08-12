<?php

namespace App\Listeners;

use App\Services\StockService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInventory
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->stockNeedsUpdate)
            $this->stockService->updateStocksInventory($event->order, $event->increment);
    }
}
