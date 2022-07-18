<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return auth()->user()->coupons()->latest()->paginate(15);
        return view('website.coupon.index')->with('points', auth()->user()->total_points);
    }

    public function validateCoupon(Request $request)
    {
        $request->validate(['coupon' => ['required', 'string']]);
        if ($coupon = Coupon::validate($request->coupon, auth()->id())) {
            return response()->json($coupon);
        }
        return abort(401, "کد تخفیف وارد شده معتبر نیست و یا منقضی شده است");
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $user = auth()->user();

        if ($request->amount > $user->total_points || $request->amount > 250) {
            return abort(402, "امتیاز شما کافی نیست");
        }

        $points = $user->points()->whereExpired(false)->whereUsed(false)->get();

        $accumulated = 0;
        $selectedPoints = collect([]);
        $created_at = null;

        $points->each((function ($point) use (&$accumulated, &$selectedPoints, &$created_at, $request) {
            $accumulated += $point->amount;
            $selectedPoints->push($point);
            if ($accumulated >= $request->amount) {
                $created_at = $point->getRawOriginal('created_at');
                return false;
            }
            return true;
        }));

        DB::beginTransaction();

        try {
            $coupon = $user->coupons()->create([
                'code' => Str::random(10),
                'points' => $request->amount,
                'discount' => (int)($request->amount / 50) * 20000
            ]);

            $user->points()->create([
                'amount' => -$request->amount,
                'description' => "تبدیل امتیاز به کوپن تخفیف"
            ]);

            $user->total_points -= $request->amount;

            $user->save();

            Point::whereIn('id', $selectedPoints->pluck('id')->toArray())->update(['used' => true]);
            if ($accumulated > $request->amount)
                $user->points()->create([
                    'amount' => $accumulated - $request->amount,
                    'description' => 'باقیمانده تبدیل امتیاز به کوپن تخفیف',
                    'created_at' => $created_at
                ]);

            DB::commit();
            return response()->json($coupon);
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(500, "Server Error!");
        }
    }
}
