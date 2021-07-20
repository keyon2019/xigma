<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    CONST STATUSES = [
        '1' => 'ثبت اولیه',
        '2' => 'در حال پردازش',
        '3' => 'ارسال شده',
        '4' => 'تکمیل شده',
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

    public function getStatusNameAttribute($value)
    {
        return self::STATUSES[$value];
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->withPivot('quantity');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
