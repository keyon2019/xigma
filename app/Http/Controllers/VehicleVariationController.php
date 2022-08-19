<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehicleVariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Vehicle $vehicle, Request $request)
    {
        Gate::authorize('edit-product');
        $vehicle->variations()->attach($request->variation_id);
        return response([]);
    }

    public function destroy(Vehicle $vehicle, Request $request)
    {
        Gate::authorize('edit-product');
        $vehicle->variations()->detach($request->variation_id);
        return response([]);
    }
}
