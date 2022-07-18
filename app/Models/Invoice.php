<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, Shamsi, Filterable;

    protected $fillable = ['total', 'vat'];

    public function variations()
    {
        return $this->belongsToMany(Variation::class)
            ->with('picture')
            ->withPivot(['quantity', 'price', 'discount']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
