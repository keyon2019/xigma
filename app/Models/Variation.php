<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'sku', 'splash', 'price', 'old_price', 'points'];

    protected $with = ['values'];

    protected $appends = ['filters'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(Value::class)->withPivot('product_id', 'option_id');
    }

    public function scopeWithProduct($query)
    {
        $query->with(['product' => function ($q) {
            return $q->without('variations', 'pictures');
        }]);
    }

    public function getFiltersAttribute()
    {
        return implode('/', $this->values->pluck('name')->toArray());
    }
}
