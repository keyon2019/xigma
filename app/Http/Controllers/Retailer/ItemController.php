<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sold(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|numeric'
        ]);

        Item::whereIn('id', $request->items)->update(['sold' => true]);

        return response([], 200);
    }
}
