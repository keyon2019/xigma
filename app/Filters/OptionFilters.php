<?php

namespace App\Filters;


class OptionFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}