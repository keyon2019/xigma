<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'content', 'meta_title', 'meta_description', 'position', 'parent', 'link'];

    protected $with = ['subs'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getRedirectLinkAttribute()
    {
        return $this->link != null ? $this->link : "/$this->slug";
    }

    public function scopeRoot($query)
    {
        return $query->whereNull("parent");
    }

    public function subs()
    {
        return $this->hasMany(Page::class, 'parent');
    }
}
