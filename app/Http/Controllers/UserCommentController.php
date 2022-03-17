<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->comments()->paginate(15));
//        return view('dashboard.comment.index');
    }
}
