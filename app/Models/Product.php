<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'description', 'price', 'old_price', 'splash'];

    protected $with = ['variations', 'pictures'];

    protected $appends = ['splashPath'];

    public function getSplashPathAttribute()
    {
        if ($pic = Picture::find($this->splash)) {
            return $pic->path;
        }
        return null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'picturable');
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class);
    }
}
