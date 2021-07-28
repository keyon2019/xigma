<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name'];

    protected $with = ['values'];

    public function values()
    {
        return $this->hasMany(Value::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}
