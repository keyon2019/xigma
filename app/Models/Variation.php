<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Variation extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'sku', 'splash', 'price', 'old_price', 'points'];

    protected $with = ['values'];

    protected $appends = ['filters', 'available'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function values()
    {
        return $this->belongsToMany(Value::class)->withPivot('product_id', 'option_id');
    }

    public function scopeWithProduct($query)
    {
        $query->with(['product' => function ($q) {
            return $q->without('variations');
        }]);
    }

    public function getFiltersAttribute()
    {
        return implode('/', $this->values->pluck('name')->toArray());
    }

    public function getAvailableAttribute()
    {
        return $this->items()->whereSold(false)->exists();
    }

    public function prepareForTable($quantity)
    {
        if (!$this->product)
            $this->load('product');
        $this->quantity = $quantity;
        $this->splash = Storage::url($this->product->pictures->firstWhere('id', $this->splash)->path ?? '');
        $this->productName = $this->product->name;
        return $this;
    }

    public function picture()
    {
        return $this->hasOne(Picture::class, 'id', 'splash');
    }
}
