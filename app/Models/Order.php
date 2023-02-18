<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Shamsi, Filterable;

    const STATUSES = [
        '1' => 'ثبت فاکتور',
        '2' => 'بررسی سفارش',
        '3' => 'آماده‌سازی',
        '4' => 'ارسال شد',
        '5' => 'لغو شده'
    ];

    const SHIPPING_METHODS = [
        '1' => 'دریافت در محل',
        '2' => 'پست',
        '3' => 'باربری'
    ];

    const COST_PREFERENCES = [
        '1' => 'مقرون به صرفه‌ترین',
        '2' => 'سریع‌ترین'
    ];

    protected $fillable = ['address_id', 'shipping_method',
        'cost_preference', 'status', 'total', 'paid', 'receiver', 'receiver_number', 'vat', 'discount', 'coupon',
        'refunded_at', 'refund_gateway', 'refund_reference_number', 'financial_id'
    ];

    protected $appends = ['statusName'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getShippingMethodAttribute($value)
    {
        return self::SHIPPING_METHODS[$value];
    }

    public function getCostPreferenceAttribute($value)
    {
        return self::COST_PREFERENCES[$value];
    }

    public function getStatusNameAttribute()
    {
        return $this->status ? self::STATUSES[$this->status] : '';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function successfulPayment()
    {
        return $this->hasOne(Payment::class)->whereSuccessful(true);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->withPivot(['quantity', 'price', 'discount', 'shipping_id']);
    }

    public function getGroupedVariationsAttribute()
    {
        return $this->variations->groupBy('id')->map(function ($group) {
            $v = $group[0];
            $v->quantity = $group->sum('pivot.quantity');
            $v->price = $group[0]->pivot->price;
            $v->discount = $group[0]->pivot->discount;
            return $v;
        });
    }

    public function getGroupedByShippingsAttribute()
    {
        return $this->variations->groupBy('pivot.shipping_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    public function getRetailersAttribute()
    {
        //todo new order retailers
//        return $this->shippings->
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function getAcceptedReturnRequestsAttribute()
    {
        return $this->returnRequests->filter(function ($r) {
            return $r->status == 4 || $r->status == 6;
        });
    }

    public function getPointsAttribute()
    {
        return $this->variations()->sum('order_variation.points');
    }

    public function orderCoupon()
    {
        return $this->hasOne(Coupon::class);
    }
}
