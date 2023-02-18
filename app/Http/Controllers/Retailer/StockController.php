<?php

namespace App\Http\Controllers\Retailer;

use App\Filters\VariationFilters;
use App\Http\Controllers\Controller;
use App\Models\Variation;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, VariationFilters $filters)
    {
        if ($request->wantsJson()) {
            $retailerIds = auth()->user()->retailers()->pluck('id')->toArray();
            $items = Variation::filter($filters)
                ->with('product')
                ->whereHas('stocks', function ($q) use ($retailerIds) {
                    return $q->whereIn('stocks.retailer_id', $retailerIds);
                })->with(['stocks' => function ($q) use ($retailerIds) {
                    return $q->whereIn('stocks.retailer_id', $retailerIds);
                }])->paginate(15);
            return response($items);
        }
        return view('retailer.stock.index');
    }
}
