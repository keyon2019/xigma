<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class VariationFilters extends QueryFilter
{
    public function product_name($value)
    {
        $this->query->whereHas('product', function (Builder $query) use ($value) {
            return $query->where('name', 'like', "%$value%");
        });
    }
}