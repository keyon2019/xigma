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
        $request->validate(['code' => 'required']);

        $shipping->update([
            'code' => $request->code,
            'sailed' => true,
            'sailed_at' => Carbon::now()->toDateTimeString()
        ]);

        return response([], 200);
    }
}
