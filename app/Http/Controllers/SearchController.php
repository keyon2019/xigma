<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate(['keyword' => 'required|string|min:3']);
        $keyword = $data['keyword'];
        return response()->json([
            'products' => Product::where('name', 'like', "%$keyword%")
                ->orWhereHas('variations', function ($q) use ($keyword) {
                    return $q->where('name', 'like', "%$keyword%");
                })->limit(8)->get(),
            'categories' => Category::where('name', 'like', "%$keyword%")->limit(3)->get(),
        ]);
    }
}
