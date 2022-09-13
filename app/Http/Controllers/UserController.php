<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Filters\UserFilters;
use App\Models\User;
use App\Rules\Mobile;
use App\Rules\SSN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('updateRoles');
    }

    public function index(Request $request)
    {
        Gate::authorize('edit-user');
        if ($request->wantsJson())
            return response()->json(User::search($request->search)->latest()->paginate(15));
        return view('dashboard.user.index');
    }

    public function create()
    {
        Gate::authorize('edit-user');
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('edit-user');
        $validated = $request->validate([
            'name' => 'required|string',
            'mobile' => ['required', new Mobile(), 'unique:users,mobile'],
            'email' => 'nullable|string',
            'telephone' => 'nullable|string',
            'emergency_mobile' => [new Mobile()],
            'password' => 'required|string|min:8',
            'is_retailer' => 'boolean',
            'ssn' => [new SSN()],
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json(['user' => $user]);
    }

    public function edit(User $user, Role $role)
    {
        Gate::authorize('edit-user');
        return view('dashboard.user.edit', compact('user'))
            ->with('roles', $role);
    }

    public function update(User $user, Request $request)
    {
        Gate::authorize('edit-user');
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => ['nullable', 'email', "unique:users,email,$user->id"],
            'mobile' => [new Mobile(), "unique:users,mobile,$user->id"],
            'telephone' => 'string',
            'emergency_mobile' => [new Mobile()],
            'password' => 'string',
            'ssn' => [new SSN()],
            'birthday' => 'date',
            'is_retailer' => 'boolean',
            'is_active' => 'boolean'
        ]);

        if ($validated['mobile'] && !auth()->user()->is_admin) {
            unset($validated['mobile']);
        }

        if ($request->has('password'))
            $validated['password'] = Hash::make($request->password);

        $user->update($validated);
        return response([], 200);
    }

    public function updateRoles(User $user, Request $request)
    {
        $request->validate(['roles' => 'required|array']);
        $user->update(['roles' => $request->roles]);
        return response([]);
    }

    public function search(Request $request, UserFilters $filters)
    {
        Gate::authorize('edit-user');
        $request->validate(['search' => 'required|string']);
        $users = User::filter($filters)->take(10)->get();
        return response()->json(['users' => $users]);
    }
}
