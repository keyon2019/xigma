<?php

namespace App\Http\Controllers;

use App\Filters\CommentFilters;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('store');
        $this->middleware('auth')->only('store');
    }

    public function index(Request $request, CommentFilters $filters)
    {
        if ($request->wantsJson())
            return response()->json(Comment::filter($filters)->with(['user', 'product'])->latest()->paginate(15));
        return view('dashboard.comment.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'numeric',
            'text' => 'required|string',
            'product_id' => 'required|numeric|exists:products,id'
        ]);
        auth()->user()->comments()->create($data);
        return response([]);
    }

    public function approve(Comment $comment)
    {
        $comment->approved = true;
        $comment->save();
        return response([]);
    }

    public function disapprove(Comment $comment)
    {
        $comment->approved = false;
        $comment->save();
        return response([]);
    }
}
