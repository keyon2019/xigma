<?php

namespace App\Interfaces;


abstract class CartInterface
{
    public $items;

    abstract public function get();

    abstract public function add($variation_id, $count = 1);

    abstract public function remove($variation_id, $count = null);

    abstract public function clear();

    abstract public function preparedForDB();

    abstract public function checkAllAvailable($allAvailable, $notAllAvailable);

    public function totalQuantity()
    {
        return $this->items->count();
    }

    public function totalPrice()
    {
        return $this->items->sum('orderPrice');
    }
}