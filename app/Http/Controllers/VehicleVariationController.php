<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleVariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(Vehicle $vehicle, Request $request)
    {
        $vehicle->variations()->attach($request->variation_id);
        return response([]);
    }

    public function destroy(Vehicle $vehicle, Request $request)
    {
        $vehicle->variations()->detach($request->variation_id);
        return response([]);
    }
}
