<?php

namespace App\Http\Controllers;

use App\Filters\OrderFilters;
use App\Http\Requests\StoreOrderRequest;
use App\Interfaces\CartInterface;
use App\Interfaces\GatewayInterface;
use App\Models\Item;
use App\Models\Order;
use App\Services\ClosestItemFinderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['all', 'edit']);
    }

    public function all(Request $request, OrderFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Order::filter($filters)->with('user')->paginate(15));
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

    public function store(StoreOrderRequest $request, CartInterface $cart, GatewayInterface $gateway, ClosestItemFinderService $closestItemFinderService)
    {
        return $cart->checkAllAvailable(function () use ($request, $cart, $gateway, $closestItemFinderService) {

            $items = $closestItemFinderService->find($request->address_id, $cart->items, $request->cost_preference);

            $shippingCosts = $items->groupBy('stock_id')->mapWithKeys(function ($shipping, $stock) {
                return [$stock ? $stock : 'null' => $shipping->max('delivery_cost')];
            });

            $shippings = array_map(function ($shipping, $key) use ($shippingCosts) {
                $shipping['stock_id'] = $shipping['stock'] == 'null' ? null : $shipping['stock'];
                unset($shipping['stock']);
                if ($shipping['method'] == 2) {
                    $shipping['cost'] = $shippingCosts[$key];
                } else {
                    $shipping['cost'] = 0;
                }
                return $shipping;
            }, $request->shipping_methods, array_keys($request->shipping_methods));


            $order = auth()->user()->orders()->create($request->validated() + [
                    'status' => 1,
                    'total' => $cart->totalPrice() + collect($shippings)->sum('cost')
                ]);

            $createdShippings = $order->shippings()->createMany($shippings);

            $itemShippingsToUpdate = $items->map(function ($item) use ($createdShippings) {
                return [
                    'id' => $item->id,
                    'shipping_id' => $createdShippings->firstWhere('stock_id', $item->stock_id)->id
                ];
            });

            Item::updateValues($itemShippingsToUpdate->toArray());

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
            ->with('order', $order->load(['user', 'address', 'items', 'shippings', 'variations.product']))
            ->with('orderStatuses', json_encode(Order::STATUSES));
    }
}
