<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $orders = Order::latest()->with('user')->whereHas('shippings', function ($q) {
            return $q->whereHas('stock', function ($q) {
                $q->whereUserId(auth()->id());
            });
        })->paginate(15);
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $shipping = $order->shippings()->with('items')->whereHas('stock', function ($q) {
            $q->whereUserId(auth()->id());
        })->first();
        return response()->json(['shipping' => $shipping, 'address' => $order->address]);
    }
}
