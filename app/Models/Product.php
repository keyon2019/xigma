<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasGallery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable, HasGallery;

    protected $fillable = ['name', 'description', 'price', 'old_price', 'splash',
        'delivery_cost', 'is_huge', 'preorderable', 'daily_production_capacity', 'onesie'];

    protected $with = ['variations', 'pictures'];

    protected $appends = ['splashUrl', 'rating'];

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

    public function getRatingAttribute()
    {
        return $this->comments()->avg('rating');
    }
}
