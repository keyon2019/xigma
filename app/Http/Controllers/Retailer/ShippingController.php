<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sailed(Shipping $shipping, Request $request)
    {
        if (!in_array($shipping->stock_id, auth()->user()->retailers->pluck('id')->toArray())) {
            abort(402, "Unauthorized!");
        }
        $validated = $request->validate([
            'sailed_at' => 'required|date',
            'code' => 'numeric'
        ]);

        $validated['sailed'] = true;

        $shipping->update($validated);

        return back()->with(['flash_message' => json_encode(['message' => 'ارسال با موفقیت ثبت شد', 'type' => 'success'])]);
    }
}
