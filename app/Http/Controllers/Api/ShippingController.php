<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function sail(Shipping $shipping, Request $request)
    {
        $request->validate(['items' => 'array']);
        $diff = array_diff($shipping->items->pluck('id')->toArray(), $request->items);
        DB::transaction(function () use ($request, $diff, $shipping) {
            Item::whereIn('id', $request->items)->update(['sold' => true, 'shipping_id' => $shipping->id, 'order_id' => $shipping->order_id]);
            Item::whereIn('id', $diff)->update(['sold' => false, 'shipping_id' => null, 'order_id' => null]);
            $shipping->update(['sailed' => true, 'sailed_at' => Carbon::now()]);
        });
        return response([], 200);
    }
}
