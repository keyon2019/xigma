<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'address', 'latitude', 'longitude', 'available'];

    protected $appends = ['coords'];

    public function items()
    {
        return $this->hasMany(Item::class, 'stock_id');
    }

    public function getCoordsAttribute()
    {
        return ['longitude' => $this->longitude, 'latitude' => $this->latitude];
    }
}
