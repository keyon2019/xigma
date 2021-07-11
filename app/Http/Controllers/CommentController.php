<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Product $product)
    {
        return response()->json(['comments' => $product->comments]);
    }
}
