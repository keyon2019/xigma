<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory, Shamsi, Filterable;

    protected $fillable = ['variation_id', 'quantity', 'current_stock'];

    protected $with = ['variation'];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
