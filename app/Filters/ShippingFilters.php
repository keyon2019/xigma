<?php

namespace App\Filters;


class ShippingFilters extends QueryFilter
{
    public function status($value)
    {
        $this->query->whereMethod($value);
    }

    public function from($value)
    {
        $this->query->whereDate('created_at', '>=', $value);
    }

    public function to($value)
    {
        $this->query->whereDate('created_at', '<=', $value);
    }
}