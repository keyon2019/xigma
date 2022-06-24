<?php

namespace App\Http\Controllers;

use App\Interfaces\CartInterface;
use App\Models\Invoice;
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

    public function fromInvoice(Request $request, Invoice $invoice, CartInterface $cart, StockService $stockService)
    {
        if (auth()->id() !== $invoice->user_id) {
            abort(401);
        }
        $type = "success";
        $message = "سبد خرید با موفقیت به روزرسانی شد";

        $collection = $invoice->variations->mapWithKeys(function ($variation) {
            return [$variation->pivot->variation_id => $variation->pivot->quantity];
        });

        $result = $stockService->checkInventoryBatch($collection);

        if ($request->has('clear'))
            $cart->clear();

        if (!$result->every(function ($item) {
            return $item->available;
        })) {
            $type = "danger";
            $message = "موجودی برخی محصولات انتخابی تغییر کرده است لطفا سبد خرید خود را مجدد بررسی نمایید";

            $cart->batchAdd($result->filter(function ($item) {
                return $item->available;
            })->mapWithKeys(function($item, $key) use ($collection) {
                return [$item->variation_id => $collection[$key]];
            }));

        } else {
            $cart->batchAdd($collection);
        }

        return redirect('/cart')->with('flash_message',
            json_encode(['message' => $message, 'type' => $type]));
    }

    public function destroy(Request $request, CartInterface $cart)
    {
        $request->validate(['variation_id' => 'required|numeric']);

        $cart->remove($request->variation_id);

        return response([]);
    }

}
