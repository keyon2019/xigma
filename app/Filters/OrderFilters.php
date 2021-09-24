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

    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}