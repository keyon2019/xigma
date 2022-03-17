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
        if ($request->wantsJson()) {
            $result = $request->has('paginated') ? auth()->user()->addresses()->latest()->paginate(15) : ['addresses' => auth()->user()->addresses];
            return response()->json($result);
        }
        return view('website.address.index');
    }

    public function store(Request $request)
    {
        $address = auth()->user()->addresses()->create($request->all() + ['latitude' => $request->lat, 'longitude' => $request->lng]);
        return response()->json(['address' => $address]);
    }
}
