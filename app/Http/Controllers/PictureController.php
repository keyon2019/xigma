<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'picturable_id' => 'numeric',
            'picturable_type' => 'string',
        ]);

        if (!$request->has('picturable_id') || !$request->has('picturable_type')) {
            $path = $request->file('file')->store('images');
            return response()->json(['url' => Storage::url($path)]);
        }

        $filePath = $request->file('file')->store('images');

        $picture = Picture::create($validated + ['path' => $filePath]);
        return response()->json(['picture' => $picture]);
    }

    public function destroy(Picture $picture)
    {
        $picture->delete();
        return response([], 200);
    }
}
