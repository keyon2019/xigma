<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('show');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Page::paginate($request->has('n') ? $request->n : 15));
        return view('dashboard.page.index');
    }

    public function show(Page $page)
    {
        return view('website.page', compact('page'));
    }

    public function create()
    {
        return view('dashboard.page.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'content' => 'string',
            'position' => 'required|numeric',
            'meta_title' => 'string',
            'meta_description' => 'string'
        ]);

        $page = Page::create($validated);

        return response()->json(['page' => $page]);
    }

    public function edit(Page $page)
    {
        return view('dashboard.page.edit', compact('page'));
    }

    public function update(Page $page, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'content' => 'string',
            'position' => 'required|numeric',
            'meta_title' => 'string',
            'meta_description' => 'string'
        ]);
        $page->update($validated);

        return response([]);
    }
}
