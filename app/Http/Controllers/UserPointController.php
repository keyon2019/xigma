<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserPointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        Gate::authorize('edit-user');
        return response()->json($user->points()->latest()->paginate(15));
    }

    public function store(User $user, Request $request)
    {
        Gate::authorize('edit-user');
        $validated = $request->validate([
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'description' => 'required|string'
        ]);

        if ($validated['amount'] < 0 && abs($validated['amount']) > $user->total_points) {
            return abort(401, "میزان امتیاز کسری بیش از کل امتیاز قابل استفاده کاربر است");
        }

        $validated['used'] = $validated['amount'] <= 0;

        $user->total_points += $validated['amount'];

        $user->save();

        $point = Point::create($validated);

        return response()->json($point);
    }
}
