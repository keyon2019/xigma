<?php

namespace App\Http\Controllers;

use App\Interfaces\CartInterface;
use App\Models\Slider;
use App\Models\Widget;
use App\TopProducts;

class HomeController extends Controller
{

    public function index(TopProducts $top, CartInterface $cart)
    {
        return view('website.home')
            ->with('isHome', true)
            ->with('topProducts', $top)
            ->with('widgets', Widget::with('categoryItSelf')->orderBy('order')->get())
            ->with('sliders', Slider::orderBy('order')->get());
    }
}
