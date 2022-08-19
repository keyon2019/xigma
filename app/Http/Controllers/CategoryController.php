<?php

namespace App\Http\Controllers;

use App\Filters\CategoryFilters;
use App\Filters\ProductFilters;
use App\Image;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function index(Request $request, CategoryFilters $filters)
    {
        Gate::authorize('edit-product');
        if ($request->wantsJson())
            return response()->json(Category::filter($filters)->paginate($request->has('n') ? $request->n : 15));
        return view('dashboard.category.index');
    }

    public function show(Category $category, ProductFilters $filters)
    {
        $category->withAncestors();
        if (request()->wantsJson()) {
            return response()->json($category->withSubCategoryProducts()
                ->withAvailability()->without('variations')
                ->filter($filters)->latest()->paginate(12));
        }
        return view('website.category.show', compact('category'))->with(['options' => Option::all()]);
    }

    public function create()
    {
        Gate::authorize('edit-product');
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('edit-product');
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'splash' => 'file',
            'wide_splash' => 'file',
            'parent_id' => $request->parent_id ? 'numeric|exists:categories,id' : '',
            'show' => 'boolean',
            'featured' => 'boolean',
            'order' => 'numeric',
            'show_slider' => 'boolean'
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
        Gate::authorize('edit-product');
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Category $category, Request $request)
    {
        Gate::authorize('edit-product');
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'splash' => 'file',
            'wide_splash' => 'file',
            'parent_id' => $request->parent_id ? 'numeric|exists:categories,id' : '',
            'show' => 'boolean',
            'featured' => 'boolean',
            'order' => 'numeric',
            'show_slider' => 'boolean'
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
        Gate::authorize('edit-product');
        $category->splash->delete();
        $category->wide_splash->delete();
        Widget::whereCategory($category->id)->delete();
        $category->delete();
        return response([], 200);
    }
}
