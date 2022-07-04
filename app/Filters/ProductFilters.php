<?php

namespace App\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductFilters extends QueryFilter
{
    public function keyword($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }

    public function sku($value)
    {
        $this->query->whereHas('variations', function($q) use ($value) {
            return $q->where('sku', $value);
        });
    }

    public function search($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }

    public function available($value)
    {
        $this->query->whereHas('variations', function (Builder $query) {
            return $query->whereRaw("exists (select * from `retailers` right join `stocks` on `retailers`.`id` = `stocks`.`retailer_id`
             where `variations`.`id` = `stocks`.`variation_id` and `quantity` > 0)");
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

    public function pictured($value)
    {
        $this->query->whereHas('pictures');
    }

    public function category($value)
    {

    }

    public function sort($value)
    {
        switch ($value) {
            case "popular":
                return $this->query->join('variations as v', 'v.id', 'products.id')
                    ->join('order_variation as ov', 'ov.variation_id', 'v.id')
                    ->join('orders as o', 'o.id', 'ov.order_id')
                    ->groupBy('ov.variation_id')
                    ->select('products.*', DB::raw("SUM(ov.quantity) as total"))
                    ->orderByDesc('total');
            case "expensive":
                return $this->query->orderByDesc("price");
            case "cheap":
                return $this->query->orderBy("price");
            default:
                return $this->query->orderByDesc('created_at');
        }
    }
}