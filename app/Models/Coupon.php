<?php

namespace App\Models;

use App\Traits\Shamsi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Coupon extends Model
{
    use HasFactory, Shamsi;

    protected $fillable = ['user_id', 'code', 'points', 'discount', 'order_id'];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        return $this->order_id ? 'استفاده شده' : 'استفاده نشده';
    }

    public static function validate($code, $user_id)
    {
        try {
            $coupon = Coupon::whereCode($code)->whereNull('order_id')->firstOrFail();
            if ($coupon->user_id != $user_id ||
                Carbon::parse($coupon->getRawOriginal('created_at'))->lte(Carbon::now()->subYear())) {
                return false;
            }
            return $coupon;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
