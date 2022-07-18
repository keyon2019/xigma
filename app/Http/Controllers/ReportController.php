<?php

namespace App\Http\Controllers;

use App\Enum\ReturnRequestStatus;
use App\Filters\InvoiceFilters;
use App\Filters\OrderFilters;
use App\Filters\PointFilters;
use App\Filters\ProductFilters;
use App\Filters\ReturnRequestFilters;
use App\Models\Order;
use App\Models\Point;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Scopes\VisibleProductsScope;
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
        return view('dashboard.report.order');
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
        return view('dashboard.report.product');
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
}
