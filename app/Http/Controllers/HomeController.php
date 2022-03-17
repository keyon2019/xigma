<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Widget;
use App\TopProducts;

class HomeController extends Controller
{

    public function index(TopProducts $top)
    {
//        dd(Widget::with('categoryItSelf')->orderBy('order')->get()->first()->categoryItSelf->name);
        return view('website.home')
            ->with('isHome', true)
            ->with('topProducts', $top)
            ->with('widgets', Widget::with('categoryItSelf')->orderBy('order')->get())
            ->with('sliders', Slider::orderBy('order')->get());
    }
}
