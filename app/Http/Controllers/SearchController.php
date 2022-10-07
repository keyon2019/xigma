<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilters;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate(['keyword' => 'required|string|min:3']);
        $keyword = $data['keyword'];
        $products = Product::with('categories')
            ->where('name', 'like', "%$keyword%")
            ->orWhereHas('variations', function ($q) use ($keyword) {
                return $q->where('name', 'like', "%$keyword%")
                    ->orWhere('sku', "$keyword");
            })->limit(8)->get();
        return response()->json([
            'products' => $products,
            'categories' => $products->pluck('categories')->flatten()->unique('id')->take(3)->values(),
        ]);
    }

    public function show(Request $request, ProductFilters $filters)
    {
        $data = $request->validate(['keyword' => 'required|string|min:3']);
        $keyword = $data['keyword'];
        if ($request->wantsJson()) {
            $products = Product::filter($filters)
                ->withAvailability()
                ->orWhereHas('variations', function ($q) use ($keyword) {
                    return $q->where('name', 'like', "%$keyword%")
                        ->orWhere('sku', "$keyword");
                })->paginate(16);
            return response()->json($products);
        }
        return view('website.search', compact('keyword'));
    }
}
