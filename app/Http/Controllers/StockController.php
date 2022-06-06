<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function supply(Request $request, StockService $stockService)
    {
        $request->validate(['variation_id' => 'required|numeric|exists:variations,id']);
        return response()->json($stockService->supply($request->variation_id));
    }

    public function update(Variation $variation, Request $request, StockService $stockService)
    {
        $request->validate([
            'quantity' => 'required|numeric|gte:0',
            'retailer_id' => 'nullable|numeric|exists:retailers,id'
        ]);

        $stockService->updateInventory($variation, $request->quantity, $request->retailer_id);

        return response([], 200);
    }
}
