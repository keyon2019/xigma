<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Option::latest()->paginate(10));
        return view('dashboard.option.index');
    }

    public function create()
    {
        return view('dashboard.option.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        return response()->json(['option' => Option::create($validated)]);
    }

    public function edit(Option $option)
    {
        return view('dashboard.option.edit', compact('option'));
    }

    public function update(Option $option, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $option->update($validated);

        return response([]);
    }
}
