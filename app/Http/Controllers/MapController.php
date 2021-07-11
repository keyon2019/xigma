<?php

namespace App\Http\Controllers;

use App\Services\MapService;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function search(Request $request, MapService $mapService)
    {
        return response()->json(['result' => $mapService->search($request->keyword)]);
    }
}
