<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function commit(Request $request)
    {
        //todo check stock_id to be same as user retailer_id
        $request->validate(['barcode' => 'required|string']);
        try {
            $item = Item::whereBarcode($request->barcode)->firstOrFail()
                ->only(['id', 'variation_id', 'barcode', 'stock_id']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'محصول مورد نظر یافت نشد'], 404);
        }

        return response()->json(['item' => $item]);
    }

    public function sold(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|numeric'
        ]);

        Item::whereIn('id', $request->items)->update(['sold' => true]);

        return response([], 200);
    }
}
