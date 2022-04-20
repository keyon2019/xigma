<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Shamsi, Filterable;

    CONST STATUSES = [
        '1' => 'ثبت فاکتور',
        '2' => 'بررسی سفارش',
        '3' => 'آماده‌سازی',
        '4' => 'ارسال شد',
        '5' => 'لغو شده'
    ];

    CONST SHIPPING_METHODS = [
        '1' => 'دریافت در محل',
        '2' => 'ارسال با پیک',
        '3' => 'ارسال با باربری'
    ];

    CONST COST_PREFERENCES = [
        '1' => 'مقرون به صرفه‌ترین',
        '2' => 'سریع‌ترین'
    ];

    protected $fillable = ['address_id', 'shipping_method', 'cost_preference', 'status', 'total', 'paid'];

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
        return self::STATUSES[$this->status];
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
        return $this->belongsToMany(Variation::class)->withPivot(['quantity', 'price', 'discount']);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    public function getRetailersAttribute()
    {
        return Retailer::whereHas('items', function ($q) {
            $q->whereOrderId($this->id);
        })->with('user')->get();
    }
}
