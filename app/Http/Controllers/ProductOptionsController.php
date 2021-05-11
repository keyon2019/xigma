<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(Product $product, Request $request)
    {
        $product->options()->syncWithoutDetaching($request->option_id);
        return response([]);
    }

    public function destroy(Product $product, Request $request)
    {
        $product->options()->detach($request->option_id);
        DB::table('value_variation')->whereOptionId($request->option_id)->whereProductId($product->id)->delete();
        return response([]);
    }
}
