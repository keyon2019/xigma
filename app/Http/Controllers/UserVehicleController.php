<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function userVehicles(User $user)
    {
        Gate::authorize('edit-user');
        return response()->json($user->vehicles()->paginate(15));
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
