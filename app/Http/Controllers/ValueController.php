<?php

namespace App\Http\Controllers;

use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string', 'option_id' => 'required|numeric']);
        return response()->json(['value' => Value::create($validated)]);
    }

    public function update(Value $value, Request $request)
    {
        $validated = $request->validate(['name' => 'required|string']);
        $value->update($validated);
        return response([]);
    }

    public function destroy(Value $value)
    {
        $value->delete();
        return response([]);
    }
}
