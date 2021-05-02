<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function store(Product $product, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'sku' => 'string',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'splash' => 'numeric',
            'options' => 'array'
        ]);

        $variation = $product->variations()->create($validated);

        if ($request->has('options'))
            $variation->values()->sync($this->optionsAsArray($variation, $request->options));

        return response()->json(['variation' => $variation->fresh()]);
    }

    public function update(Variation $variation, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'sku' => 'string',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'splash' => 'numeric',
            'options' => 'array'
        ]);

        $variation->update($validated);

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
