<?php

namespace App\Filters;


class ThreadFilters extends QueryFilter
{
    public function seen($value)
    {
        $this->query->whereSeen($value);
    }

    public function userName($value)
    {
        return $this->query->whereHas('user', function ($q) use ($value) {
            return $q->whereName($value);
        });
    }

    public function userMobile($value)
    {
        return $this->query->whereHas('user', function ($q) use ($value) {
            return $q->whereMobile($value);
        });
    }
}