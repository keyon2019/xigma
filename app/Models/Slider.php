<?php

namespace App\Models;

use App\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'button_text', 'url', 'order', 'left', 'picture', 'mobile_picture'];

    public function getPictureAttribute($value)
    {
        return new Image($value);
    }

    public function getMobilePictureAttribute($value)
    {
        return new Image($value);
    }
}
