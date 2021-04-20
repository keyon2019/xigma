<?php

namespace App\Filters;


class ProductFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}