<?php

namespace App\Http\Controllers;

use App\Image;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Category::paginate(15));
        return view('dashboard.category.index');
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
            'wide_splash' => 'file'
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
            'wide_splash' => 'file'
        ]);
        if ($request->hasFile('splash')) {
            $validated['splash'] = $category->splash->update($request->file('splash'));
        }

        if ($request->hasFile('wide_splash')) {
            $validated['wide_splash'] = $category->splash->update($request->file('wide_splash'));
        }

        $category->update($validated);

        return response([]);
    }
}
