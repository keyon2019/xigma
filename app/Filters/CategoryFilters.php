<?php

namespace App\Filters;


class CategoryFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}