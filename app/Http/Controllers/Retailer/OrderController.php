<?php

namespace App\Http\Controllers\Retailer;

use App\Filters\OrderFilters;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, OrderFilters $filters)
    {
        if ($request->wantsJson()) {
            $orders = Order::latest()->with('user')
                ->whereHas('shippings', function ($q) {
                    return $q->whereHas('stock', function ($q) {
                        $q->whereUserId(auth()->id());
                    });
                })->with(['shippings' => function ($q) {
                    return $q->whereHas('stock', function ($q) {
                        $q->whereUserId(auth()->id());
                    });
                }])->filter($filters)->paginate(15)->through(function ($order) {
                    $order->shipping = $order->shippings->first();
                    return $order;
                });
            return response()->json($orders);
        }
        return view('retailer.order.index');
    }

    public function show($order)
    {
        $stocks = auth()->user()->retailers->pluck('id')->toArray();
        $order = Order::with(['variations', 'shippings' => function ($q) use ($stocks) {
            return $q->whereIn('stock_id', $stocks);
        }])->find($order);
        $shippings = $order->shippings->filter(function ($shipping) use ($stocks) {
            return in_array($shipping->stock_id, $stocks);
        })->pluck('id')->toArray();

        $order->variations = $order->variations->filter(function ($v) use ($shippings) {
            return in_array($v->pivot->shipping_id, $shippings);
        });

        return view('retailer.order.show')->with([
            'order' => $order,
        ]);
    }
}
