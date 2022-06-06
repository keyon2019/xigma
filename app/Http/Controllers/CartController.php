<?php

namespace App\Http\Controllers;

use App\Interfaces\CartInterface;
use App\Models\Item;
use App\Models\Variation;
use App\Services\StockService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartInterface $cart, Request $request)
    {
        if ($request->wantsJson())
            return response()->json(['items' => $cart->items, 'vehicles' => auth()->check() ? auth()->user()->vehicles->load('variations') : []]);
        return view('website.cart.index')->with('items', $cart->items);
    }

    public function store(Request $request, CartInterface $cart, StockService $stockService)
    {
        $request->validate(['variation_id' => 'required|numeric', 'quantity' => 'numeric']);
        if ($stockService->checkInventory($request->variation_id, $request->quantity)) {
            $cart->add($request->variation_id, $request->quantity);
            return response()->json(['item' => Variation::find($request->variation_id)->prepareForTable($request->quantity)]);
        }
        return abort('402', 'موجودی محصول کافی نیست');
    }

    public function destroy(Request $request, CartInterface $cart)
    {
        $request->validate(['variation_id' => 'required|numeric']);

        $cart->remove($request->variation_id);

        return response([]);
    }

}
