<?php

namespace App\Http\Controllers;

use App\Filters\ItemFilters;
use App\Models\Item;
use App\Models\Retailer;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('retailers');
    }

    public function index(Variation $variation, Request $request, ItemFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json($variation->items()->with('stock')->filter($filters)->orderBy('barcode', 'desc')->paginate(15));
        return view('dashboard.item.index', compact('variation'));
    }

    public function store(Variation $variation, Request $request)
    {
        $request->validate([
            'prefix' => 'required|string',
            'start' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        $items = [];
        for ($barcode = $request->start; $barcode <= $request->start + $request->quantity; $barcode++) {
            array_push($items, ['variation_id' => $variation->id, 'barcode' => $request->prefix . $barcode, 'created_at' => Carbon::now()->toDateTimeString()]);
        }

        DB::table('items')->insert($items);

        return response([], 200);
    }

    public function retailers(Variation $variation)
    {
        $retailers = Retailer::whereHas('items', function ($q) use ($variation) {
            return $q->whereVariationId($variation->id)->whereSold(false);
        })->get();
        return response()->json(['retailers' => $retailers]);
    }

    public function find(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);
        try {
            $item = Item::with('variation')->whereSold(false)
                ->whereNull('stock_id')
                ->whereBarcode($request->barcode)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'محصول مورد نظر یافت نشد'], 404);
        }

        return response()->json(['item' => $item]);
    }
}
