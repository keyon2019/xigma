<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, Shamsi, Filterable;

    protected $guarded = ['id'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
