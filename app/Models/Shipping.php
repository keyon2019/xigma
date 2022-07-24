<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shipping extends Model
{
    use HasFactory, Shamsi, Filterable;

    protected $fillable = ['method', 'stock_id', 'cost', 'sailed_at', 'code'];

    protected $dates = ['sailed_at'];

    protected $with = ['stock'];

    protected $appends = ['methodName'];

    public function stock()
    {
        return $this->belongsTo(Retailer::class, 'stock_id');
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class, 'order_variation')->withPivot(['quantity', 'price', 'discount']);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getMethodNameAttribute()
    {
        return Order::SHIPPING_METHODS[$this->method];
    }

}
