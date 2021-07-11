<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class HomeController extends Controller
{

    public function index()
    {
        return view('website.home')
            ->with('isHome', true)
            ->with('sliders', Slider::orderBy('order')->get());
    }
}
