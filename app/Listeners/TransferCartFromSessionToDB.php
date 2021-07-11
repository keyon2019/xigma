<?php

namespace App\Listeners;

use App\Cart\DatabaseCart;
use App\Cart\SessionCart;
use App\Interfaces\CartInterface;

class TransferCartFromSessionToDB
{

    protected $sessionCart;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SessionCart $sessionCart)
    {
        $this->sessionCart = $sessionCart;
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user->cart()->syncWithoutDetaching($this->sessionCart->preparedForDB());
    }
}
