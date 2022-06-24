<?php

namespace App\Filters;


class ReturnRequestFilters extends QueryFilter
{
    public function created_at($value)
    {
        $this->query->whereDate('created_at', $value);
    }

    public function status($value)
    {
        $this->query->whereStatus($value);
    }

    public function name($value)
    {
        return $this->query->whereHas('user', function ($q) use ($value) {
            return $q->whereName($value);
        });
    }

    public function mobile($value)
    {
        return $this->query->whereHas('user', function ($q) use ($value) {
            return $q->whereMobile($value);
        });
    }

    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }
}