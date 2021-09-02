<?php

namespace App\Http\Controllers;

use App\Models\Retailer;
use Illuminate\Http\Request;

class RetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Retailer::paginate(15));
        return view('dashboard.retailer.index');
    }

    public function create()
    {
        return view('dashboard.retailer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'city' => 'string',
            'address' => 'string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'available' => 'boolean'
        ]);

        $retailer = Retailer::create($validated);
        return response()->json(['retailer' => $retailer]);
    }

    public function edit(Retailer $retailer)
    {
        return view('dashboard.retailer.edit', compact('retailer'));
    }

    public function update(Retailer $retailer, Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'city' => 'string',
            'address' => 'string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'available' => 'boolean'
        ]);

        $retailer->update($validated);

        return response([]);
    }
}
