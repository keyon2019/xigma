<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasGallery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasGallery, Filterable;

    protected $fillable = ['name', 'description', 'splash'];

    protected $with = ['variations', 'pictures'];

    protected $appends = ['splashUrl'];

    public function getSplashUrlAttribute()
    {
        if ($pic = Picture::find($this->splash)) {
            return $pic->url;
        }
        return null;
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class, 'vehicle_variation');
    }
}
