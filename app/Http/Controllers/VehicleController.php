<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request, VehicleFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Vehicle::filter($filters)->paginate(10));
        return view('dashboard.vehicle.index');
    }

    public function create()
    {
        return view('dashboard.vehicle.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
        ]);

        $vehicle = Vehicle::create($validated);
        return response()->json(['vehicle' => $vehicle]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('dashboard.vehicle.edit', compact('vehicle'));
    }

    public function update(Vehicle $vehicle, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'splash' => 'numeric'
        ]);

        $vehicle->update($validated);
        return response([]);
    }

    public function destroy(Vehicle $vehicle)
    {
        Storage::delete($vehicle->splash);
        $vehicle->delete();
        return back();
    }
}
