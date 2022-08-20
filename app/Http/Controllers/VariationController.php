<?php

namespace App\Http\Controllers;

use App\Filters\VariationFilters;
use App\Http\Requests\StoreVariationRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use App\Scopes\VisibleProductsScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['search', 'index']);
    }

    public function index(VariationFilters $filters)
    {
        if (\request()->wantsJson())
            return response()->json(Variation::withStock()
                ->filter($filters)->with(['product' => function ($q) {
                    $q->withoutGlobalScope(VisibleProductsScope::class)->without('variations', 'pictures');
                }])->paginate(15));
        return view('dashboard.variation.index')->with('categories', Category::root()->with('subCategories')->get());
    }

    public function store(Product $product, StoreVariationRequest $request)
    {
        Gate::authorize('edit-product');
        $variation = $product->variations()->create($request->validated());

        if ($request->has('options'))
            $variation->values()->sync($this->optionsAsArray($variation, $request->options));

        return response()->json(['variation' => $variation->fresh()]);
    }

    public function update(Variation $variation, StoreVariationRequest $request)
    {
        Gate::authorize('edit-product');
        $variation->update($request->validated());

        if ($request->has('options'))
            $variation->values()->sync($this->optionsAsArray($variation, $request->options));

        return response([]);
    }

    public function destroy(Variation $variation)
    {
        Gate::authorize('edit-product');
        try {
            $variation->delete();
            return response([]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        $request->validate(['keyword' => 'required|string|min:3']);
        $keyword = $request->keyword;
        $response = Variation::whereHas('product', function ($q) use ($keyword) {
            return $q->where('name', 'like', "%$keyword%");
        })->orWhere('name', 'like', "%$keyword%")->orWhere('sku', "$keyword")->limit(10)->get();
        return response()->json(['result' => $response]);
    }

    private function optionsAsArray($variation, $options)
    {
        $arr = [];
        foreach ($options as $optionId => $valueId) {
            $arr[$valueId] = ['product_id' => $variation->product_id, 'option_id' => $optionId];
        }
        return $arr;
    }
}
