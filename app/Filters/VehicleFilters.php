<?php

namespace App\Filters;


class VehicleFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}