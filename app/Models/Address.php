<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['province_id', 'city_id', 'latitude', 'longitude', 'zip', 'mobile', 'phone', 'directions'];

    protected $with = ['city', 'province'];

    protected $appends = ['cityName', 'provinceName'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getNearbyStocksAttribute()
    {
        return DB::table('retailers')
            ->select('retailers.id')
            ->selectRaw("SQRT(POWER($this->latitude - retailers.latitude, 2) +
                 POWER($this->longitude - retailers.longitude, 2)) as distance")
            ->orderByRaw('distance')->get()->pluck('id')->toArray();
    }

    public function getCityNameAttribute()
    {
        return $this->city ? $this->city->name : '';
    }

    public function getProvinceNameAttribute()
    {
        return $this->province ? $this->province->name : '';
    }
}
