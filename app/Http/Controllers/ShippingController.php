<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Shipping $shipping, Request $request)
    {
        Gate::authorize('edit-shipping');
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
