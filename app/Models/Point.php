<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Point extends Model
{
    use HasFactory, Shamsi, Filterable;

    protected $fillable = ['user_id', 'amount', 'used', 'depleted', 'description', 'created_at'];

    protected $appends = ['status', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExpiresAtAttribute()
    {
        if ($this->amount > 0 && $this->used)
            return "استفاده شده";
        return $this->amount > 0 ? Jalalian::forge(Carbon::parse($this->getRawOriginal('created_at'))->addYear())->format("Y/m/d") : "";
    }

    public function getStatusAttribute()
    {
        return Carbon::parse($this->getRawOriginal('created_at'))->toDate() >= Carbon::now()->subYear() ? 'معتبر' : 'منقضی';
    }
}
