<?php

namespace App\Http\Controllers;

use App\Enum\ReturnRequestStatus;
use App\Filters\InvoiceFilters;
use App\Filters\OrderFilters;
use App\Filters\PointFilters;
use App\Filters\ProductFilters;
use App\Filters\ReturnRequestFilters;
use App\Filters\ShippingFilters;
use App\Models\Order;
use App\Models\Point;
use App\Models\Product;
use App\Models\Province;
use App\Models\Reminder;
use App\Models\ReturnRequest;
use App\Models\Shipping;
use App\Models\Vehicle;
use App\Scopes\VisibleProductsScope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function order(OrderFilters $filters, Request $request)
    {
        if ($request->wantsJson()) {
            $orders = Order::filter($filters)->get();
            return response()->json([
                'rows' => $orders,
                'count' => $orders->count(),
                'sum' => $orders->sum('total')
            ]);
        }
        return view('dashboard.report.order')
            ->with('provinces', Province::all());
    }

    public function point(PointFilters $filters, Request $request)
    {
        if ($request->wantsJson()) {
            if ($request->has('grouped') && $request->grouped != null) {
                $points = Point::join('users as u', 'u.id', 'points.user_id')
                    ->where('amount', '>', 0)->filter($filters);
                $points
                    ->select('u.name as userName', 'u.id as userId')
                    ->selectRaw('SUM(points.amount) as amount')
                    ->orderByDesc('amount')
                    ->groupBy('u.id');
            } else {
                $points = Point::with('user')->where('amount', '>', 0)->filter($filters);
            }
            $points = $points->get();
            return response()->json([
                'rows' => $points,
                'count' => $points->count(),
                'sum' => $points->sum('amount')
            ]);
        }
        return view('dashboard.report.point');
    }

    public function product(Request $request)
    {
        $query = Product::without(['variations', 'pictures', 'comments'])
            ->withoutGlobalScope('rating')->withoutGlobalScope(VisibleProductsScope::class)
            ->join('variations as v', 'v.product_id', 'products.id')
            ->leftJoin('order_variation as ov', 'v.id', 'ov.variation_id')
            ->leftJoin('orders as o', 'o.id', 'ov.order_id')
            ->select('products.id as id', 'v.id as variationId', 'v.name as name', 'products.name as productName')
            ->selectRaw('IFNULL(SUM(ov.quantity), 0) as totalQuantity')
            ->selectRaw('IFNULL(SUM(ov.quantity * ov.price), 0) as totalSold')
            ->selectRaw('IFNULL(SUM(ov.quantity * ov.points), 0) as totalPoints')
            ->groupBy('v.id');

        if ($request->has('desc') && $request->desc != null) {
            $query->orderByDesc('totalSold');
            $query->orderByDesc('totalQuantity');
        } else {
            $query->orderBy('totalSold');
            $query->orderBy('totalQuantity');
        }

        if ($request->has('province_id') && $request->province_id != null) {
            $query->join('addresses as ad', 'o.address_id', 'ad.id')
                ->where('ad.province_id', $request->province_id);
        }

        if ($request->has('vehicle_id') && $request->vehicle_id != null) {
            $query->join('vehicle_variation as vh', 'vh.variation_id', 'v.id')
                ->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->has('from') && $request->from != null) {
            $query->whereDate('o.created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to != null) {
            $query->whereDate('o.created_at', '<=', $request->to);
        }

        if ($request->wantsJson()) {
            $products = $query->get();
            return response()->json($products);
        }
        return view('dashboard.report.product')
            ->with('provinces', Province::all())
            ->with('vehicles', Vehicle::all());
    }

    public function category(Request $request)
    {
        $query = Product::without(['variations', 'pictures', 'comments'])
            ->withoutGlobalScope('rating')->withoutGlobalScope(VisibleProductsScope::class)
            ->join('variations as v', 'v.product_id', 'products.id')
            ->leftJoin('category_product as cp', 'cp.product_id', 'products.id')
            ->join('categories as c', 'c.id', 'cp.category_id')
            ->leftJoin('order_variation as ov', 'v.id', 'ov.variation_id')
            ->leftJoin('orders as o', 'o.id', 'ov.order_id')
            ->select('c.id', 'c.name')
            ->selectRaw('IFNULL(SUM(ov.quantity), 0) as totalQuantity')
            ->selectRaw('IFNULL(SUM(ov.quantity * ov.price), 0) as totalSold')
            ->selectRaw('IFNULL(SUM(ov.quantity * ov.points), 0) as totalPoints')
            ->groupBy('c.id');

        if ($request->has('desc') && $request->desc != null) {
            $query->orderByDesc('totalSold');
            $query->orderByDesc('totalQuantity');
        } else {
            $query->orderBy('totalSold');
            $query->orderBy('totalQuantity');
        }

        if ($request->has('from') && $request->from != null) {
            $query->whereDate('o.created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to != null) {
            $query->whereDate('o.created_at', '<=', $request->to);
        }

        if ($request->wantsJson()) {
            $products = $query->get();
            return response()->json($products);
        }
        return view('dashboard.report.category');
    }

    public function returnRequest(ReturnRequestFilters $filters, Request $request)
    {
        $query = DB::table('return_requests')
            ->join('variations as v', 'v.id', 'return_requests.variation_id')
            ->join('products as p', 'p.id', 'v.product_id')
            ->select('p.name as productName', 'v.name as name')
            ->selectRaw('SUM(return_requests.quantity * return_requests.price) as totalPrice')
            ->selectRaw('SUM(return_requests.quantity) as totalQuantity')
            ->whereIn('status', [ReturnRequestStatus::REFUNDED, ReturnRequestStatus::RETURNED])
            ->groupBy('v.id')
            ->orderByDesc('totalQuantity');

        if ($request->has('from') && $request->from != null) {
            $query->whereDate('return_requests.created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to != null) {
            $query->whereDate('return_requests.created_at', '<=', $request->to);
        }

        if ($request->wantsJson())
            return response()->json($query->get());
        return view('dashboard.report.return_request');
    }

    public function shipping(Request $request, ShippingFilters $shippingFilters)
    {
        if ($request->wantsJson()) {
            $shippings = Shipping::filter($shippingFilters)->latest()->get();
            return response()->json([
                'rows' => $shippings,
                'count' => $shippings->count(),
                'sum' => $shippings->sum('cost')
            ]);
        }
        return view('dashboard.report.shipping');
    }

    public function shippingAverageTime(Request $request, OrderFilters $filters)
    {
        $query = Order::join('shippings as sh', 'sh.order_id', 'orders.id')
            ->selectRaw('orders.id, CONVERT(AVG(DATEDIFF(sh.sailed_at,orders.created_at)), UNSIGNED) as averageDays')
            ->groupBy('orders.id')
            ->orderByDesc('orders.created_at')
            ->havingRaw('averageDays IS NOT NULL');

        if ($request->has('from') && $request->from != null) {
            $query->whereDate('orders.created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to != null) {
            $query->whereDate('orders.created_at', '<=', $request->to);
        }

        $shippings = $query->get();

        if ($request->wantsJson()) {
            return response()->json([
                'rows' => $shippings,
                'average' => number_format($shippings->avg('averageDays'))
            ]);
        }

        return view('dashboard.report.shipping_average');
    }

    public function reminder(Request $request)
    {
        $query = Reminder::selectRaw('variation_id, count(variation_id) as count')
            ->with('variation.product')
            ->groupBy('variation_id')
            ->orderByDesc('count')
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'rows' => $query,
            ]);
        }

        return view('dashboard.report.reminder');
    }

    public function productExitAverage(Request $request)
    {
        if (!$request->wantsJson()) {
            return view('dashboard.report.product_exit_average');
        }
        if (!$request->has('from') || !$request->has('to')) {
            return response([]);
        }
        $from = Carbon::parse($request->from);
        $days = $from->diffInDays($request->to);

        $query = Product::without(['variations', 'pictures', 'comments'])
            ->withoutGlobalScope('rating')->withoutGlobalScope(VisibleProductsScope::class)
            ->join('variations as v', 'v.product_id', 'products.id')
            ->join('order_variation as ov', 'v.id', 'ov.variation_id')
            ->join('orders as o', 'o.id', 'ov.order_id')
            ->whereDate('o.created_at', '>=', $request->from)
            ->whereDate('o.created_at', '<=', $request->to)
            ->select('products.id as id', 'v.id as variationId', 'v.sku as sku', 'v.name as name', 'products.name as productName')
            ->selectRaw("(IFNULL(SUM(ov.quantity), 0) / $days) as exit_average")
            ->orderByDesc('exit_average')
            ->groupBy('v.id');

        return response()->json([
            'rows' => $query->get(),
        ]);
    }
}
