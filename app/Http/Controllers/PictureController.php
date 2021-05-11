<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file',
            'picturable_id' => 'required|numeric',
            'picturable_type' => 'required|string',
        ]);

        $filePath = $request->file('file')->store('images');

        $picture = Picture::create($validated + ['path' => $filePath]);
        return response()->json(['picture' => $picture]);
    }
}
