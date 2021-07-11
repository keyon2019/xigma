<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'gateway', 'token', 'reference_number', 'successful'];

    protected $casts = ['successful' => 'boolean'];

    protected $with = ['order'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getGatewayAttribute($value)
    {
        $gateway = array_values(array_filter(config('gateway'), function ($arr) use ($value) {
            return $arr['id'] == $value;
        }))[0];
        $gatewayClassName = $gateway['class'];
        $class = "\App\Gateways\\$gatewayClassName";
        return new $class();
    }
}
