<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function update(Shipping $shipping, Request $request)
    {
        $validated = $request->validate([
            'code' => 'required',
            'sailed_at' => 'nullable|date'
        ]);

        $validated['sailed'] = true;
        if ($validated['sailed_at'] == null)
            unset($validated['sailed_at']);

        $shipping->update($validated);

        return response([], 200);
    }
}
