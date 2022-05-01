<?php

namespace App\Http\Controllers;

use App\Filters\UserFilters;
use App\Models\User;
use App\Rules\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(User::search($request->search)->paginate(15));
        return view('dashboard.user.index');
    }

    public function create()
    {
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'mobile' => ['required', new Mobile()],
            'email' => 'nullable|string',
            'password' => 'required|string',
            'is_retailer' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json(['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('dashboard.user.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'mobile' => ['required', new Mobile()],
            'email' => 'nullable|string',
            'password' => 'string',
            'is_retailer' => 'boolean',
            'is_active' => 'boolean'
        ]);

        if ($request->has('password'))
            $validated['password'] = Hash::make($request->password);

        $user->update($validated);
        return response([], 200);
    }

    public function search(Request $request, UserFilters $filters)
    {
        $request->validate(['search' => 'required|string']);
        $users = User::search($request->search)->filter($filters)->take(10)->get();
        return response()->json(['users' => $users]);
    }
}
