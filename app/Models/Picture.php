<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['picturable_id', 'picturable_type', 'path'];

    protected $appends = ['url'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Picture $picture) {
            Storage::delete($picture->path);
        });
    }

    public function picturable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
