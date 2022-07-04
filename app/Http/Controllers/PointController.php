<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function overview()
    {
        return view('website.point.overview')->with('points', auth()->user()->total_points);
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->points()->orderBy('id', 'desc')->paginate(5));
        return view('website.point.index');
    }
}
