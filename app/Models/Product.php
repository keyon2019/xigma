<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasGallery;
use App\Traits\Shamsi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable, HasGallery, Shamsi;

    protected $fillable = ['name', 'description', 'price', 'special_price', 'splash',
        'delivery_cost', 'is_huge', 'preorderable', 'daily_production_capacity', 'onesie', 'special_price_expiration'];

    protected $with = ['variations', 'pictures'];

    protected $dates = ['special_price_expiration'];

    protected $appends = ['splashUrl', 'orderPrice'];

    protected static function booted()
    {
        static::addGlobalScope('rating', function (Builder $builder) {
            return $builder->withAvg('comments as rating', 'rating');
        });
    }

    public function getOrderPriceAttribute()
    {
        if ($this->getRawOriginal('special_price_expiration') > Carbon::now()->toDateTimeString())
            return $this->special_price;
        return $this->price;
    }

    public function scopeWithAvailability($query)
    {
        return $query->withExists(['variations as available' => function ($query) {
            return $query->whereHas('items', function ($query) {
                $query->whereSold(false);
            });
        }]);
    }

    public function getSplashUrlAttribute()
    {
        if ($pic = $this->pictures->firstWhere('id', $this->splash)) {
            return $pic->url;
        }
        return null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
