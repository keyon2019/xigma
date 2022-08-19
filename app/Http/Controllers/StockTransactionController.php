<?php

namespace App\Http\Controllers;

use App\Events\ProductIsNowAvailable;
use App\Filters\StockTransactionFilters;
use App\Models\StockTransaction;
use App\Models\Variation;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request, StockTransactionFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(StockTransaction::filter($filters)->latest()->paginate(15));
        return view('dashboard.stock_transaction.index');
    }

    public function store(Request $request, StockService $stockService)
    {
        $validated = $request->validate([
            'variation_id' => 'required|numeric|exists:variations,id',
            'quantity' => 'required|numeric|gt:0'
        ]);
        $t = DB::transaction(function () use ($stockService, $request, $validated) {
            $current_stock = $stockService->getInventoryCount($request->variation_id);
            $validated['current_stock'] = $current_stock + $request->quantity;
            $transaction = StockTransaction::create($validated);
            $transaction->load('variation');
            $stockService->updateInventory($transaction->variation, $validated['quantity']);
            if ($current_stock == 0) {
                event(new ProductIsNowAvailable($transaction->variation));
            }
            return $transaction;
        });

        return response()->json($t);
    }
}
