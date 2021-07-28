<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Interfaces\CartInterface;
use App\Interfaces\GatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['all', 'edit']);
    }

    public function all(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Order::with('user')->paginate(15));
        return view('dashboard.order.index');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->orders()->latest()->paginate(10));
        return view('website.order.index');
    }

    public function show(Order $order)
    {
        return view('website.order.show')->with('order', $order->load('variations', 'items'));
    }

    public function store(StoreOrderRequest $request, CartInterface $cart, GatewayInterface $gateway)
    {
        return $cart->checkAllAvailable(function () use ($request, $cart, $gateway) {
            $order = auth()->user()->orders()->create($request->validated() + [
                    'status' => 1,
                    'total' => $cart->totalPrice()
                ]);

            $orderVariations = $cart->items->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        'quantity' => $item->quantity,
                    ]
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

    public function edit(Order $order)
    {
        return view('dashboard.order.edit')
            ->with('order', $order->load(['user', 'address', 'items', 'variations.product']))
            ->with('orderStatuses', json_encode(Order::STATUSES));
    }
}
