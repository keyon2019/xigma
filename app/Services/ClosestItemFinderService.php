<?php


namespace App\Services;


use App\Models\Address;
use Illuminate\Support\Facades\DB;

class ClosestItemFinderService
{
    public function find($address_id, $items, $method)
    {
        $address = Address::find($address_id);
        $nearbyStocks = $address->nearbyStocks;
        array_splice($nearbyStocks, $method, 0, -1);
        $nearbyStocks = implode(',', $nearbyStocks);
        $results = [];

        foreach ($items as $index => $item) {
            $baseTable = DB::table('items')
                ->leftJoin('retailers', 'retailers.id', 'items.stock_id')
                ->join('variations', 'variations.id', 'items.variation_id')
                ->join('products', 'variations.product_id', 'products.id')
                ->select(['items.id', 'items.variation_id', 'items.stock_id', 'variations.name', 'products.is_huge', 'products.delivery_cost',
                    DB::raw('(CASE WHEN variations.special_price_expiration > NOW() THEN variations.special_price ELSE variations.price END) as price')])
                ->selectRaw('retailers.latitude, retailers.longitude, retailers.address as retailerAddress, retailers.name as retailerName, retailers.id as retailerId')
                ->where('items.sold', false)
                ->orderByRaw("items.variation_id, FIELD(IFNULL(`items`.`stock_id`, -1), $nearbyStocks)");

            $t = "base$index";

            $baseTable->joinSub($baseTable, $t, function ($join) use ($item, $t) {
                $join->on("$t.id", "items.id")->where("$t.variation_id", $item->id);
            })->limit($item->quantity ?? $item->pivot->quantity);

            array_push($results, $baseTable);
        }

        $b = array_shift($results);

        foreach ($results as $r) {
            $b->union($r);
        }

        return $b->get();
    }
}