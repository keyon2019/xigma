<?php

namespace App\Http\Controllers;

use App\Filters\CommentFilters;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, CommentFilters $filters)
    {
        Gate::authorize('edit-user');
        if ($request->wantsJson())
            return response()->json(Comment::filter($filters)->with(['user', 'product'])->latest()->paginate(15));
        return view('dashboard.comment.index');
    }

    public function userComments(Request $request)
    {
        Gate::authorize('edit-user');
        if ($request->wantsJson())
            return response()->json(auth()->user()->comments()->with('product')->latest()->paginate(15));
        return view('website.comment.index');
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

    public function update(Comment $comment, Request $request)
    {
        Gate::authorize('edit-user');
        $comment->reply = $request->reply;
        $comment->save();
        return response([]);
    }

    public function approve(Comment $comment)
    {
        Gate::authorize('edit-user');
        $comment->approved = true;
        $comment->save();
        return response([]);
    }

    public function disapprove(Comment $comment)
    {
        Gate::authorize('edit-user');
        $comment->approved = false;
        $comment->save();
        return response([]);
    }
}
