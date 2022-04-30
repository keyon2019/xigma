<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\Mobile;
use App\Rules\ValidOTP;
use App\Services\SMSService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', new Mobile(), 'unique:users,mobile'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'otp' => ['required', 'numeric', 'digits:4', new ValidOTP(\request()->get('mobile'))],
            'agreed' => 'required|boolean'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function otp(Request $request, SMSService $service)
    {
        $data = $request->validate([
            'mobile' => ['required', 'numeric', 'unique:users,mobile', new Mobile()]
        ]);

        $otp = rand(1000, 9999);
        Cache::put($data['mobile'], $otp, 60 * 10);

        $service->send($data['mobile'], __('auth.otp', ['code' => $otp]));

        return response([], 200);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'numeric', new Mobile()],
            'otp' => 'required|numeric|digits:4'
        ]);

        if (Cache::get($data['mobile']) == $data['otp']) {
            return response([], 200);
        }
        return response()->json(['message' => "کد وارد شده صحیح نیست و یا منقضی شده است"], 401);
    }
}
