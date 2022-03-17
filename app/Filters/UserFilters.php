<?php

namespace App\Filters;


class UserFilters extends QueryFilter
{
    public function retailer($value)
    {
        $this->query->whereIsRetailer($value);
    }
}