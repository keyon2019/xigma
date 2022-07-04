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
        return view('dashboard.page.create')->with('topMenus', Page::wherePosition(1)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'link' => 'string',
            'name' => 'required|string',
            'slug' => 'required_without:link|string',
            'content' => 'string',
            'position' => 'required|numeric',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'parent' => 'nullable|numeric',
        ]);

        $page = Page::create($validated);

        return response()->json(['page' => $page]);
    }

    public function edit(Page $page)
    {
        return view('dashboard.page.edit', compact('page'))->with('topMenus', Page::wherePosition(1)->get());
    }

    public function update(Page $page, Request $request)
    {
        $validated = $request->validate([
            'link' => 'string',
            'name' => 'required|string',
            'slug' => 'required_without:link|string',
            'content' => 'string',
            'position' => 'required|numeric',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'parent' => "nullable|numeric",
        ]);

        if ($page->id == $validated['parent'])
            return abort(402, "منو و سرگروه نمی‌توانند یکی باشند");

        $page->update($validated);

        return response([]);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response([], 200);
    }
}
