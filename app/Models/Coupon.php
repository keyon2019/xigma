<?php

namespace App\Models;

use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, Shamsi;

    protected $fillable = ['user_id', 'code', 'points', 'discount'];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        return $this->order_id ? 'استفاده شده' : 'استفاده نشده';
    }
}
