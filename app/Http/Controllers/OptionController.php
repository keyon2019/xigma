<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Option::latest()->paginate(10));
        return view('dashboard.option.index');
    }
}
