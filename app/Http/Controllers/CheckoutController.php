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

    public function index(CartInterface $cart, ShippingService $shippingService)
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
        return response()->json($shippingService->findStores($request->address_id, $cart->items, $request->cost_preference));
    }
}
