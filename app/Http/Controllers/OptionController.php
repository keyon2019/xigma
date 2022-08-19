<?php

namespace App\Http\Controllers;

use App\Filters\OptionFilters;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, OptionFilters $filters)
    {
        Gate::authorize('edit-product');
        if ($request->wantsJson())
            return response()->json(Option::filter($filters)->latest()->paginate(10));
        return view('dashboard.option.index');
    }

    public function create()
    {
        Gate::authorize('edit-product');
        return view('dashboard.option.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('edit-product');
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        return response()->json(['option' => Option::create($validated)]);
    }

    public function edit(Option $option)
    {
        Gate::authorize('edit-product');
        return view('dashboard.option.edit', compact('option'));
    }

    public function update(Option $option, Request $request)
    {
        Gate::authorize('edit-product');
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $option->update($validated);

        return response([]);
    }

    public function destroy(Option $option)
    {
        Gate::authorize('edit-product');
        $option->delete();
        return response([]);
    }
}
