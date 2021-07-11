<?php

namespace App\Cart;

use App\Interfaces\CartInterface;
use App\Models\Variation;
use Illuminate\Support\Facades\Storage;

class SessionCart extends CartInterface
{
    public $items;

    public function __construct()
    {
        $this->items = $this->get();
    }

    public function get()
    {
        if ($this->raw() != null) {
            return $this->preservedKeys()->values();
        }
        return collect([]);
    }

    private function raw()
    {
        return session()->get('cart.items');
    }

    public function add($variation_id, $quantity = 1)
    {
        return session()->put("cart.items.$variation_id", $quantity);
    }

    public function remove($variation_id, $count = null)
    {
        return !!session()->pull("cart.items.$variation_id");
    }

    public function clear()
    {
        session()->forget('cart.items');
    }

    public function preparedForDB()
    {
        return $this->preservedKeys()->map(function ($item) {
            return ['quantity' => $item->quantity];
        })->toArray();
    }

    private function preservedKeys()
    {
        $raw = $this->raw();
        if ($raw != null) {
            $variations = Variation::withProduct()->find(array_keys($raw));
            return collect($raw)->map(function ($quantity, $variation_id) use ($variations) {
                $v = $variations->firstWhere('id', $variation_id);
                $v->prepareForTable($quantity);
                return $v;
            });
        }
        return collect([]);
    }

    public function checkAllAvailable($allAvailable, $notAllAvailable)
    {
        return $notAllAvailable([]);
    }
}