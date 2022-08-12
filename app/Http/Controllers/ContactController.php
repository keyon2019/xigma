<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Rules\Mobile;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('index');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Contact::latest()->paginate(15));
        return view('dashboard.contact.index');
    }

    public function show()
    {
        return view('website.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'mobile' => ['required', new Mobile()],
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        Contact::create($validated);
        return response([]);
    }
}
