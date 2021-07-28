<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class ItemFilters extends QueryFilter
{
    public function orderBy($value)
    {
        $tmp = explode('.', $value);
        $columnName = $tmp[0];
        $order = $tmp[1] ?? 'asc';
        $this->query->orderBy($columnName, $order);
    }

    public function variation($value)
    {
        $this->query->whereVariationId($value);
    }
}