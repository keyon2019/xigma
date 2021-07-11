<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Interfaces\CartInterface;
use App\Models\Shipping;
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
        return view('website.checkout.index');
    }

    public function analyze(CartInterface $cart, Request $request, ShippingService $shippingService)
    {
        $stocks = $shippingService->findStores($request->address_id, $cart->items, $request->shipping_method);
        $methods = $shippingService->availableMethods($cart, $request->cost_preference, $stocks);

        return response()->json(['stocks' => $stocks, 'methods' => $methods]);
    }
}
