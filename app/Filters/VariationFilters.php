<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class VariationFilters extends QueryFilter
{
    public function orderBy($value)
    {
        $tmp = explode('.', $value);
        $columnName = $tmp[0];
        $order = count($tmp) > 1 ? 'desc' : 'asc';
        $this->query->orderBy($columnName, $order);
    }

    public function product($value)
    {
        $this->query->whereProductId($value);
    }

    public function product_name($value)
    {
        $this->query->whereHas('product', function (Builder $query) use ($value) {
            return $query->where('name', 'like', "%$value%");
        });
    }
}