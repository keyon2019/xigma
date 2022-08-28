<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Rules\Mobile;
use App\Rules\SSN;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('website.profile.index')->with('orders', auth()->user()->orders()->latest()->limit(8)->get());
    }

    public function edit()
    {
        return view('website.profile.edit')
            ->with('user', auth()->user()->load('vehicles'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email,' . auth()->id(),
            'ssn' => [new SSN()],
            'area_code' => 'nullable|numeric|digits:3',
            'telephone' => 'nullable|numeric|digits:8',
            'emergency_mobile' => ['nullable', new Mobile()],
            'birthday' => 'date',
        ]);
        $data['telephone'] = $data['area_code'] . $data['telephone'];
        auth()->user()->update($data);
        return back()->with(['flash_message' => json_encode(['message' => 'اطلاعات شما با موفقیت به روز رسانی شد', 'type' => 'success'])]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => bcrypt($data['password'])]);
        return back()->with(['flash_message' => json_encode(['message' => 'رمز عبور شما با موفقیت به روز رسانی شد', 'type' => 'success'])]);
    }
}
