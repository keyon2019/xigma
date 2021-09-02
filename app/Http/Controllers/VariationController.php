<?php

namespace App\Http\Controllers;

use App\Filters\VariationFilters;
use App\Http\Requests\StoreVariationRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(VariationFilters $filters)
    {
//        dd(\request()->all());
        if (\request()->wantsJson())
            return response()->json(Variation::withAvailableItemsCount()
                ->filter($filters)->with(['product' => function ($q) {
                    $q->without('variations', 'pictures');
                }])->paginate(15));
        return view('dashboard.variation.index')->with('categories', Category::all());
    }

    public function store(Product $product, StoreVariationRequest $request)
    {
        $variation = $product->variations()->create($request->validated());

        if ($request->has('options'))
            $variation->values()->sync($this->optionsAsArray($variation, $request->options));

        return response()->json(['variation' => $variation->fresh()]);
    }

    public function update(Variation $variation, StoreVariationRequest $request)
    {
        $variation->update($request->validated());

        if ($request->has('options'))
            $variation->values()->sync($this->optionsAsArray($variation, $request->options));

        return response([]);
    }

    public function destroy(Variation $variation)
    {
        try {
            $variation->delete();
            return response([]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
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
