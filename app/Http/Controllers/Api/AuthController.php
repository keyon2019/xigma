<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::whereEmail($validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return abort(401, "Invalid Credentials");
        }

        $token = $user->createToken('remote_assistant_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        /** @var User $user */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        $token = $user->createToken("remote_assistant_token")->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'logged out']);
    }
}
