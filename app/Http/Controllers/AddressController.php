<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(['addresses' => auth()->user()->addresses]);
        return dd(auth()->user()->addresses);
    }

    public function store(Request $request)
    {
        $address = auth()->user()->addresses()->create($request->all() + ['latitude' => $request->lat, 'longitude' => $request->lng]);
        return response()->json(['address' => $address]);
    }
}
