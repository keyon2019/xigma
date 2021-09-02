<?php

namespace App\Http\Controllers;

use App\Interfaces\CartInterface;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $gateways = array_map(function ($g) {
            return [
                'id' => $g['id'],
                'icon' => $g['icon']
            ];
        }, config('gateway'));

        return view('website.checkout.index', compact('gateways'));
    }

    public function analyze(CartInterface $cart, Request $request, ShippingService $shippingService)
    {
        $items = $shippingService->findStores($request->address_id, $cart->items, $request->cost_preference);
//        dd($stocks);
//        $methods = $shippingService->availableMethods($cart, $request->cost_preference, $stocks);

        return response()->json(['items' => $items]);
    }
}
