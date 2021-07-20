<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['province', 'city', 'latitude', 'longitude', 'zip', 'mobile', 'phone', 'directions'];

    public function getNearbyStocksAttribute()
    {
        return DB::table('retailers')
            ->select('retailers.id')
            ->selectRaw("SQRT(POWER($this->latitude - retailers.latitude, 2) +
                 POWER($this->longitude - retailers.longitude, 2)) as distance")
            ->orderByRaw('distance')->get()->pluck('id')->toArray();
    }
}
