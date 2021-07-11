<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Retailer;
use App\Models\Variation;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function retailers(Variation $variation)
    {
        $retailers = Retailer::whereHas('items', function ($q) use ($variation) {
            return $q->whereVariationId($variation->id)->whereSold(false);
        })->get();
        return response()->json(['retailers' => $retailers]);
    }
}
