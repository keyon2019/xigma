<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Retailer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'address', 'latitude', 'longitude', 'available', 'user_id'];

    protected $appends = ['coords'];

    public function items()
    {
        return $this->hasMany(Item::class, 'stock_id');
    }

    public function stocks()
    {
        return $this->belongsToMany(Variation::class, 'stocks')->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCoordsAttribute()
    {
        return ['longitude' => $this->longitude, 'latitude' => $this->latitude];
    }

    public function availableItems()
    {
        return $this->items()->with('variation')->whereSold(false)
            ->groupBy('variation_id')
            ->select('variation_id', DB::raw('count(*) as total'));
    }
}
