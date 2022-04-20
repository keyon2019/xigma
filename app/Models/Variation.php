<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Variation extends Model
{
    use HasFactory, Filterable, Shamsi;

    protected $fillable = ['name', 'sku', 'splash', 'price', 'special_price', 'points', 'special_price_expiration'];

    protected $with = ['values'];

    protected $appends = ['filters', 'available', 'orderPrice'];

    protected $dates = ['special_price_expiration'];

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

    public function getOrderPriceAttribute()
    {
        if ($this->getRawOriginal('special_price_expiration') > Carbon::now()->toDateTimeString())
            return $this->special_price;
        return $this->price;
    }

    public function scopeWithProduct($query)
    {
        $query->with(['product' => function ($q) {
            return $q->without('variations');
        }]);
    }

    public function scopeWithAvailableItemsCount($query)
    {
        return $query->withCount(['items as items_count' => function ($q) {
            return $q->whereSold(false);
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
        if ($this->product->pictures)
            $this->splash = Storage::url($this->product->pictures->firstWhere('id', $this->splash)->path ?? '');
        else {
            $this->splash = '/uploads/xigma_logo.png';
        }
        $this->productName = $this->product->name;
        $this->discount = $this->special_price_expiration > Carbon::now() ? $this->price - $this->special_price : 0;
        $this->price = $this->special_price_expiration > Carbon::now() ? $this->special_price : $this->price;
        return $this;
    }

    public function picture()
    {
        return $this->hasOne(Picture::class, 'id', 'splash');
    }
}
