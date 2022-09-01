<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('search');
    }

    public function index(Request $request, VehicleFilters $filters)
    {
        Gate::authorize('edit-product');
        if ($request->wantsJson())
            return response()->json(Vehicle::filter($filters)->paginate(10));
        return view('dashboard.vehicle.index');
    }

    public function create()
    {
        Gate::authorize('edit-product');
        return view('dashboard.vehicle.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('edit-product');
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
        ]);

        $vehicle = Vehicle::create($validated);
        return response()->json(['vehicle' => $vehicle]);
    }

    public function edit(Vehicle $vehicle)
    {
        Gate::authorize('edit-product');
        return view('dashboard.vehicle.edit', compact('vehicle'));
    }

    public function update(Vehicle $vehicle, Request $request)
    {
        Gate::authorize('edit-product');
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
        Gate::authorize('edit-product');
        Storage::delete($vehicle->splash);
        $vehicle->delete();
        return back();
    }

    public function search(Request $request, VehicleFilters $filters)
    {
        $request->validate(['keyword' => 'required|string']);
        $vehicles = Vehicle::filter($filters)->take(10)->get();
        return response()->json(['vehicles' => $vehicles]);
    }
}
