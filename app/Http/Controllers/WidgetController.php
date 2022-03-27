<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Widget;
use App\TopProducts;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }

    public function all()
    {
        return view('dashboard.widget.index')->with('widgets', Widget::all());
    }

    public function index()
    {
        return response()->json(['widgets' => Widget::with('category')->get()]);
    }

    public function create()
    {
        return view('dashboard.widget.create')->with([
            'widget' => new Widget(),
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|numeric',
            'category' => 'required|numeric',
            'order' => 'required|numeric'
        ]);

        $widget = Widget::create($data);

        return redirect("/dashboard/widget/$widget->id/edit");
    }

    public function update(Widget $widget, Request $request)
    {
        $data = $request->validate([
            'type' => 'required|numeric',
            'category' => 'required|numeric',
            'order' => 'required|numeric'
        ]);

        $widget->update($data);

        return back();
    }

    public function edit(Widget $widget)
    {
        return view('dashboard.widget.edit', compact('widget'))->with(['categories' => Category::all()]);
    }

    public function destroy(Widget $widget)
    {
        $widget->delete();
        return back();
    }

    public function purge(Widget $widget, TopProducts $top)
    {
        $top->purge($widget->type, $widget->categoryItSelf ? $widget->categoryItSelf->name : null);
        return back();
    }
}
