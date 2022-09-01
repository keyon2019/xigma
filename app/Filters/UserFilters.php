<?php

namespace App\Filters;


class UserFilters extends QueryFilter
{
    public function retailer($value)
    {
        $this->query->whereIsRetailer($value);
    }

    public function search($value)
    {
        $this->query->where('name', 'like', "%$value%")
            ->orWhere('email', 'like', "%$value")
            ->orWhere('mobile', $value);
    }

    public function province($value)
    {
        $this->query->whereHas('addresses', function ($q) use ($value) {
            $q->whereProvinceId($value);
        });
    }

    public function vehicle($value)
    {
        $this->query->whereHas('vehicles', function ($q) use ($value) {
            $q->whereId($value);
        });
    }
}