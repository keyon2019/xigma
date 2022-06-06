<?php

namespace App\Cart;

use App\Interfaces\CartInterface;
use App\Models\Item;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;

class DatabaseCart extends CartInterface
{
    public $items;

    public function __construct()
    {
        $this->items = $this->get();
    }

    public function get()
    {
        return auth()->user()->cart->each(function ($variation) {
            $variation->prepareForTable($variation->pivot->quantity);
        });
    }

    public function add($variation_id, $quantity = 1)
    {
        return auth()->user()->cart()->syncWithoutDetaching([$variation_id => ['quantity' => $quantity]]);
    }

    public function remove($variation_id, $count = null)
    {
        return auth()->user()->cart()->detach($variation_id);
    }

    public function clear()
    {
        return auth()->user()->cart()->detach();
    }

    public function preparedForDB()
    {
        $arr = [];
        $this->items->each(function ($item) use (&$arr) {
            $arr[$item->id] = [
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount
            ];
        });
        return $arr;
    }

    public function hasHugeProduct()
    {
        return Variation::whereIn('id', $this->items->pluck('id'))->whereHas('product', function ($q) {
            return $q->whereIsHuge(true);
        })->exists();
    }

    public function checkAllAvailable($allAvailable, $notAllAvailable)
    {
        return $allAvailable();
        //todo fix this
        $items = Item::whereIn('variation_id', $this->items->pluck('id'))
            ->select('variation_id', DB::raw('SUM(sold = 0) as count'))
            ->groupBy('variation_id')->get();
        $unavailableItems = $this->items->pluck('id')->diff($items->pluck('variation_id'));
        if ($unavailableItems->count() > 0) {
            return $notAllAvailable($unavailableItems->values());
        }
        $unavailableItems = [];
        foreach ($items as $item) {
            if ($item->count < $this->items->firstWhere('id', $item->variation_id)->quantity)
                array_push($unavailableItems, $item->variation_id);
        }
        return count($unavailableItems) ? $notAllAvailable($unavailableItems) : $allAvailable();
    }
}