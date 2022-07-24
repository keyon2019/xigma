<?php

namespace App\Filters;


class OrderFilters extends QueryFilter
{
    public function created_at($value)
    {
        $this->query->whereDate('created_at', $value);
    }

    public function status($value)
    {
        $this->query->whereStatus($value);
    }

    public function name($value)
    {
        return $this->query->whereHas('user', function ($q) use ($value) {
            return $q->whereName($value);
        });
    }

    public function userMobile($value)
    {
        $this->query->whereReceiverNumber($value);
    }

    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }

    public function from($value)
    {
        $this->query->whereDate('created_at', '>=', $value);
    }

    public function to($value)
    {
        $this->query->whereDate('created_at', '<=', $value);
    }

    public function province_id($value)
    {
        $this->query->whereHas('address', function ($q) use ($value) {
            return $q->whereProvinceId($value);
        });
    }
}