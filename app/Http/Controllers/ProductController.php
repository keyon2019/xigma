<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Filters\ProductFilters;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Scopes\VisibleProductsScope;
use App\TopProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function index(ProductFilters $filters, Request $request)
    {
        Gate::authorize('edit-product');
        if ($request->wantsJson())
            return response()->json(
                Product::withoutGlobalScope(VisibleProductsScope::class)
                    ->without('variations')->filter($filters)
                    ->withAvailability()->latest()->paginate(12)
            , 200, [], JSON_INVALID_UTF8_IGNORE);
        return view('dashboard.product.index')->with('options', Option::all());
    }

    public function show(Product $product, TopProducts $top)
    {
        return view('website.product.show')
            ->with('product', $product->load('variations.values.option')->load(['comments' => function ($query) {
                return $query->whereApproved(true)->latest();
            }]))
            ->with('topProducts', $top)
            ->with('category', $product->category ? $product->category->withAncestors() : new Category());
    }

    public function create()
    {
        Gate::authorize('edit-product');
        return view('dashboard.product.create');
    }

    public function store(StoreProductRequest $request)
    {
        Gate::authorize('edit-product');
        $product = Product::create($request->validated());
        return response()->json(['product' => $product]);
    }

    public function edit($id)
    {
        Gate::authorize('edit-product');
        $product = Product::withoutGlobalScope(VisibleProductsScope::class)->find($id);
        return view('dashboard.product.edit')->with('product', $product->load('options', 'categories'));
    }

    public function update($id, StoreProductRequest $request)
    {
        Gate::authorize('edit-product');
        $product = Product::withoutGlobalScope(VisibleProductsScope::class)->find($id);
        $product->update($request->validated());
        return response([]);
    }
}
