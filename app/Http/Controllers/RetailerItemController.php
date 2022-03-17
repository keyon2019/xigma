<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetailerItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        return view('dashboard.retailerItem.create');
    }

    public function send(Request $request)
    {
        DB::table('items')->whereIn('id', $request->items)
            ->update(['stock_id' => $request->stock_id]);
        return response([], 200);
    }
}
