<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Mobile;
use App\Rules\ValidOTP;
use App\Services\SMSService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function resetOtp(Request $request, SMSService $service)
    {
        $data = $request->validate([
            'mobile' => ['required', 'numeric', new Mobile(), 'exists:users,mobile']
        ]);

        $otp = rand(1000, 9999);
        Cache::put("reset_" . $data['mobile'], $otp, 60 * 10);

        $service->send($data['mobile'], $otp, SMSService::OTP);

        return response([], 200);
    }

    public function verifyResetOtp(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'numeric', new Mobile()],
            'otp' => 'required|numeric|digits:4'
        ]);

        if (Cache::get("reset_" . $data['mobile']) == $data['otp']) {
            return response([], 200);
        }
        return response()->json(['message' => "کد وارد شده صحیح نیست و یا منقضی شده است"], 401);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'numeric', new Mobile(), "exists:users,mobile"],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'otp' => ['required', 'numeric', 'digits:4'],
        ]);

        if (Cache::get("reset_" . $data['mobile']) == $data['otp']) {
            User::whereMobile($data['mobile'])->first()->update([
                'password' => Hash::make($data['password'])
            ]);
            return response()->json(['message' => 'رمز عبور با موفقیت به روزرسانی شد']);
        }

        return abort(403, "اطلاعات وارد شده صحیح نیست");
    }
}
