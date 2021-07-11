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
                ->select('items.*')
                ->selectRaw('retailers.latitude, retailers.longitude, retailers.name')
                ->where('items.sold', false)
                ->orderByRaw("items.variation_id, FIELD(IFNULL(`items`.`stock_id`, -1), $nearbyStocks)");

            $t = "base$index";

            $baseTable->joinSub($baseTable, $t, function ($join) use ($item, $t) {
                $join->on("$t.id", "items.id")->where("$t.variation_id", $item->id);
            })->limit($item->quantity);

            array_push($results, $baseTable);
        }

        $b = array_shift($results);

        foreach ($results as $r) {
            $b->union($r);
        }
        return $b->get();
    }
}