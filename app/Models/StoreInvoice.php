<?php

namespace App\Models;

use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInvoice extends Model
{
    use HasFactory, Shamsi;

    protected $fillable = ['retailer_id'];

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->withPivot(['quantity', 'price', 'discount']);
    }
}
