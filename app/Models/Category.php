<?php

namespace App\Models;

use App\Image;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'description', 'splash', 'wide_splash', 'parent_id', 'show', 'order', 'featured'];

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeVisible($query)
    {
        return $query->whereShow(true);
    }

    protected $with = ['subCategories'];

    public function withSubCategoryProducts()
    {
        return Product::whereHas('categories', function ($q) {
            return $q->whereIn('id', Category::getAllSubCategoriesIds($this));
        });
    }

    public function scopeWithAncestors()
    {
        return $this->load('parentCategory.parentCategory');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
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

    public static function getAllSubCategoriesIds($category)
    {
        $ids = collect([$category->id]);
        if ($category->subCategories) {
            $ids = $ids->concat($category->subCategories->pluck('id'));
            foreach ($category->subCategories as $cat) {
                $ids = $ids->concat(Category::getAllSubCategoriesIds($cat));
            }
        }
        return $ids->unique()->toArray();
    }
}
