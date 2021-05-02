<?php

namespace App\Models;

use App\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'splash', 'wide_splash'];

    public function getSplashAttribute($value)
    {
        return new Image($value);
    }

    public function getWideSplashAttribute($value)
    {
        return new Image($value);
    }
}
