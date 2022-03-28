<?php

namespace App\Models;

use App\Image;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'description', 'splash', 'wide_splash', 'parent_id'];

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function withSubCategoryProducts()
    {
        return Product::whereHas('categories', function ($q) {
            $q->whereIn('id', $this->load('subCategories')->pluck('id')->toArray());
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getSplashAttribute($value)
    {
        return new Image($value);
    }

    public function getWideSplashAttribute($value)
    {
        return new Image($value);
    }

    public function variations()
    {
        return Variation::whereHas('product', function ($query) {
            return $query->whereHas('categories', function ($query) {
                return $query->whereId($this->id);
            });
        });
    }
}
