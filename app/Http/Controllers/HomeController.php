<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\TopProducts;

class HomeController extends Controller
{

    public function index(TopProducts $top)
    {
        return view('website.home')
            ->with('isHome', true)
            ->with('topProducts', $top)
            ->with('sliders', Slider::orderBy('order')->get());
    }
}
