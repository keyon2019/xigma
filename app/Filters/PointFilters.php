<?php

namespace App\Filters;


class PointFilters extends QueryFilter
{
    public function from($value)
    {
        $this->query->whereDate('created_at', '>=', $value);
    }

    public function to($value)
    {
        $this->query->whereDate('created_at', '<=', $value);
    }
}