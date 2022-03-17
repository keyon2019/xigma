<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'content', 'meta_title', 'meta_description', 'position'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugValue($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
