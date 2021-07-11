<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }

    public function available($value)
    {
        $this->query->whereHas('variations', function (Builder $query) {
            return $query->withCount(['items' => function (Builder $query) {
                return $query->whereSold(false);
            }])->having('items_count', '>', 0);
        });
    }

    public function option($value)
    {
        foreach ($value as $values) {
            $this->query->whereHas('variations', function (Builder $query) use ($values) {
                return $query->whereHas('values', function (Builder $query) use ($values) {
                    return $query->whereIn('id', $values);
                });
            });
        }
    }
}