<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['address_id', 'shipping_method', 'cost_preference', 'order_status', 'total', 'paid'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->withPivot('quantity');
    }
}
