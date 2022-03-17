<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class UserVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, VehicleFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Vehicle::filter($filters)->paginate(15));
        return view('website.vehicle.index')->with('vehicles', auth()->user()->vehicles);
    }

    public function store(Request $request)
    {
        $request->validate(['vehicle_id' => 'required|numeric|exists:vehicles,id']);

        auth()->user()->vehicles()->attach($request->vehicle_id);
        return response([], 200);
    }

    public function destroy(Request $request)
    {
        $request->validate(['vehicle_id' => 'required|numeric|exists:vehicles,id']);
        auth()->user()->vehicles()->detach($request->vehicle_id);
        return response([], 200);
    }
}
