<?php

namespace App\Http\Controllers;

use App\Filters\CategoryFilters;
use App\Filters\ProductFilters;
use App\Image;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Widget;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('show');
    }

    public function index(Request $request, CategoryFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Category::filter($filters)->paginate($request->has('n') ? $request->n : 15));
        return view('dashboard.category.index');
    }

    public function show(Category $category, ProductFilters $filters)
    {
        if (request()->wantsJson()) {
            return response()->json($category->products()
                ->withAvailability()->without('variations')
                ->filter($filters)->latest()->paginate(12));
        }
        return view('website.category.show', compact('category'))->with(['options' => Option::all()]);
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'splash' => 'file',
            'wide_splash' => 'file',
            'parent_id' => $request->parent_id ? 'numeric|exists:categories,id' : ''
        ]);

        if ($request->hasFile('splash')) {
            $validated['splash'] = Image::store($request->file('splash'));
        }

        if ($request->hasFile('wide_splash')) {
            $validated['wide_splash'] = Image::store($request->file('wide_splash'));
        }

        $category = Category::create($validated);
        return response()->json(['category' => $category]);
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Category $category, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'splash' => 'file',
            'wide_splash' => 'file',
            'parent_id' => $request->parent_id ? 'numeric|exists:categories,id' : ''
        ]);

        if ($request->hasFile('splash')) {
            $validated['splash'] = $category->splash->update($request->file('splash'));
        }

        if ($request->hasFile('wide_splash')) {
            $validated['wide_splash'] = $category->wide_splash->update($request->file('wide_splash'));
        }

        $category->update($validated);

        return response([]);
    }

    public function destroy(Category $category)
    {
        $category->splash->delete();
        $category->wide_splash->delete();
        Widget::whereCategory($category->id)->delete();
        $category->delete();
        return response([], 200);
    }
}
