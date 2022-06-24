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
}