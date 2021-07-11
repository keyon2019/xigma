<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Interfaces\CartInterface;
use App\Interfaces\GatewayInterface;
use App\Models\Order;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreOrderRequest $request, CartInterface $cart, GatewayInterface $gateway)
    {
        return $cart->checkAllAvailable(function () use ($request, $cart, $gateway) {
            $order = Order::create($request->validated() + [
                    'order_status' => 1,
                    'total' => $cart->totalPrice()
                ]);

            $orderVariations = $cart->items->mapWithKeys(function ($item) {
                return [
                    $item->id => ['quantity' => $item->quantity]
                ];
            })->toArray();

            $order->variations()->attach($orderVariations);

            $createdGateway = $gateway->create($order);

//            $cart->clear();

            return response()->json(['message' => 'Order Placed Successfully', 'gateway' => [
                'post_parameters' => $createdGateway->postParameters(),
                'method' => $createdGateway->method(),
                'url' => $createdGateway->gatewayUrl(),
            ]]);

        }, function ($unavailableItems) {
            return response()->json(['message' => 'Some items are not available', 'item_ids' => $unavailableItems], 400);
        });
    }
}
