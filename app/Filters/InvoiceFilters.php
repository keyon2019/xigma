<?php

namespace App\Filters;


class InvoiceFilters extends QueryFilter
{
    public function created_at($value)
    {
        $this->query->whereDate('created_at', $value);
    }

    public function user($value)
    {
        $this->query->whereHas('user', function ($q) use ($value) {
            return $q->where('name', 'like', "%$value%");
        });
    }

    public function mobile($value)
    {
        $this->query->whereHas('user', function ($q) use ($value) {
            return $q->where('mobile', $value);
        });
    }


}