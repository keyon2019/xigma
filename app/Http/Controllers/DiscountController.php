<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        return view('dashboard.discount.create')->with('categories', Category::withCount('products')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'percent' => 'required|numeric',
            'expiration_date' => 'required|date'
        ]);

        $fractured = $validated['percent'] / 100;
        $category = Category::find($validated['category_id']);
        $category->products()->update([
            'special_price' => DB::raw("(1 - $fractured) * price"),
            'special_price_expiration' => $validated['expiration_date']
        ]);

        $category->variations()->update([
            'special_price' => DB::raw("(1 - $fractured) * price"),
            'special_price_expiration' => $validated['expiration_date']
        ]);

        return response([]);
    }
}
