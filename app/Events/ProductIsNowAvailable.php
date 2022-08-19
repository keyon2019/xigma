<?php

namespace App\Events;

use App\Models\Variation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductIsNowAvailable
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $variation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Variation $variation)
    {
        $this->variation = $variation;
    }
}
