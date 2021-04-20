<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['picturable_id', 'picturable_type', 'path'];

    public function picturable()
    {
        return $this->morphTo();
    }
}
