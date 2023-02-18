<?php

namespace App\Http\Controllers\Retailer;

use App\Filters\ItemFilters;
use App\Http\Controllers\Controller;
use App\Models\Retailer;

class RetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(Retailer::paginate(15));
    }

    public function show(Retailer $retailer, ItemFilters $filters)
    {
        return response()->json($retailer->availableItems()->filter($filters)->paginate(15));
    }
}
