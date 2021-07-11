<?php

namespace App\Http\Controllers;

use App\Image;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Slider::paginate(10));
        return view('dashboard.slider.index');
    }

    public function create()
    {
        return view('dashboard.slider.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'picture' => 'required|file',
            'button_text' => 'required|string',
            'order' => 'numeric',
            'url' => 'string',
            'left' => 'boolean'
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = Image::store($request->file('picture'));
        }

        $slider = Slider::create($validated);
        return response()->json(['slider' => $slider]);
    }

    public function edit(Slider $slider)
    {
        return view('dashboard.slider.edit', compact('slider'));
    }

    public function update(Slider $slider, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'picture' => 'file',
            'button_text' => 'required|string',
            'order' => 'numeric',
            'url' => 'string',
            'left' => 'boolean'
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $slider->picture->update($request->file('picture'));
        }

        $slider->update($validated);

        return response([]);
    }

    public function destroy(Slider $slider)
    {
        $slider->picture->delete();
        $slider->delete();
        return response([]);
    }
}
