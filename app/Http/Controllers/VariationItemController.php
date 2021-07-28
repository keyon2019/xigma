<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use Illuminate\Http\Request;

class VariationItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Variation $variation, Request $request)
    {

    }
}
