<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'type', 'order'];

    public function categoryItSelf()
    {
        return $this->belongsTo(Category::class, 'category');
    }
}
