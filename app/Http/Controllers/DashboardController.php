<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function overview()
    {
        if (auth()->user()->is_admin || auth()->user()->is_retailer || auth()->user()->roles != null)
            return view('dashboard.pages.overview');
        return abort(401, 'Unauthenticated!');
    }
}
