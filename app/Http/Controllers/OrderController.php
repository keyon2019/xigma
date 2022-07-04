<?php

namespace App\Http\Controllers;

use App\Enum\ReturnEnquiry;
use App\Enum\ReturnReason;
use App\Filters\OrderFilters;
use App\Http\Requests\StoreOrderRequest;
use App\Interfaces\CartInterface;
use App\Interfaces\GatewayInterface;
use App\Models\Item;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Services\ClosestItemFinderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['all', 'edit', 'update', 'userOrders']);
    }

    public function all(Request $request, OrderFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Order::filter($filters)->with('user')->latest()->paginate(15));
        return view('dashboard.order.index');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->orders()->latest()->paginate(10));
        return view('website.order.index');
    }

    public function userOrders(User $user)
    {
        return response()->json($user->orders()->latest()->paginate(10));
    }

    public function show(Order $order)
    {
        if (auth()->user()->id === $order->user_id)
            return view('website.order.show')
                ->with('order', $order->load('variations.values', 'items', 'shippings', 'successfulPayment', 'returnRequests'))
                ->with('reasons', new ReturnReason())
                ->with('enquiries', new ReturnEnquiry());
        return abort(401);
    }

    public function store(StoreOrderRequest $request, CartInterface $cart, GatewayInterface $gateway, ClosestItemFinderService $closestItemFinderService)
    {
        return $cart->checkAllAvailable(function () use ($request, $cart, $gateway, $closestItemFinderService) {

            $items = $closestItemFinderService->find($request->address_id, $cart->items, $request->cost_preference);

            $shippings = collect($request->shipping_methods)->map(function ($shipping, $stock_id) use ($items) {
                $shipping['stock_id'] = $shipping['stock_id'] == 'null' ? null : $shipping['stock_id'];
                if ($shipping['method'] == 2)
                    $shipping['cost'] = $items->firstWhere('retailer_id', $shipping['stock_id'])['delivery_cost'];
                else {
                    $shipping['cost'] = 0;
                }
                return $shipping;
            });

            $order = auth()->user()->orders()->create($request->validated() + [
                    'status' => 1,
                    'total' => $cart->totalPrice() + collect($shippings)->sum('cost')
                ]);

            $createdShippings = $order->shippings()->createMany($shippings);

            $orderVariations = $items->pluck('items')->flatten()->map(function ($item) use ($createdShippings, $order) {
                return [
                    'order_id' => $order->id,
                    'variation_id' => $item->variation_id,
                    'shipping_id' => $createdShippings->firstWhere('stock_id', $item->retailer_id)->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'points' => $item->points,
                    'discount' => $item->discount
                ];
            })->toArray();

            DB::table('order_variation')->insert($orderVariations);

            $createdGateway = $gateway->create($order);

            $cart->clear();

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
            ->with('order', $order->load(['user', 'address', 'items', 'shippings', 'variations.product', 'successfulPayment']))
            ->with('orderStatuses', json_encode(Order::STATUSES));
    }

    public function update(Order $order, Request $request)
    {
        $data = $request->validate(['status' => 'numeric']);
        $order->update($data);
        return response([], 200);
    }

    public function invoice(Order $order)
    {
        if (auth()->user()->id === $order->user_id)
            return view('website.order.invoice')
                ->with('order', $order->load('variations', 'items', 'shippings', 'successfulPayment','returnRequests'));
        return abort(401);
    }
}
