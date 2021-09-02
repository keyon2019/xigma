<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'stock_id', 'cost', 'sailed_at'];

    protected $dates = ['sailed_at'];

    protected $with = ['stock'];

    public function stock()
    {
        return $this->belongsTo(Retailer::class, 'stock_id');
    }

}
