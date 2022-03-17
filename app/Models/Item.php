<?php

namespace App\Models;

use App\Traits\BatchUpdatable;
use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory, BatchUpdatable, Filterable, Shamsi;

    protected $fillable = ['shipping_id', 'order_id', 'sold'];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function stock()
    {
        return $this->belongsTo(Retailer::class, 'stock_id');
    }

    public function scopeIsAvailable($query, $variation_id, $quantity = 1)
    {
        return $query->whereVariationId($variation_id)->whereSold(false)
            ->select('variation_id', DB::raw('COUNT(variation_id) as count'))
            ->groupBy('variation_id')->havingRaw("count >= ?", [$quantity])->exists();
    }
}
