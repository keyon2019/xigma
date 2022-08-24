<?php

namespace App\Http\Controllers;

use App\Enum\ShippingMethod;
use App\Models\Shipping;
use App\Services\SMSService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Shipping $shipping, Request $request, SMSService $SMSService)
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

        if ($shipping->method != ShippingMethod::PICKUP_AT_STORE)
            $SMSService->send($shipping->order->user->mobile, "{$shipping->order->user->name};{$validated['code']}",
                $shipping->method == ShippingMethod::POST ? 93579 : 93580);

        return response([], 200);
    }
}
