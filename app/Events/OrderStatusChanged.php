<?php

namespace App\Events;

use App\Enum\OrderStatus;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order, $oldStatus, $newStatus, $increment;

    public function __construct($order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->stockNeedsUpdate = false;


        if (($this->newStatus == OrderStatus::CANCELED || $this->newStatus == OrderStatus::PLACED) &&
            ($this->oldStatus == OrderStatus::INSPECTING || $this->oldStatus == OrderStatus::SHIPPED || $this->oldStatus == OrderStatus::PREPARING)) {
            $this->increment = true;
            $this->stockNeedsUpdate = true;
        }

        if (($this->newStatus == OrderStatus::INSPECTING || $this->oldStatus == OrderStatus::SHIPPED || $this->oldStatus == OrderStatus::PREPARING) &&
            ($this->oldStatus == OrderStatus::CANCELED || $this->oldStatus == OrderStatus::PLACED)) {
            $this->increment = false;
            $this->stockNeedsUpdate = true;
        }

    }

}
