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
            $quantity = $item->quantity ?? $item->pivot->quantity;
            $result = DB::query()->fromSub(function ($q) use ($nearbyStocks, $item, $index, $quantity) {
                $q->from('stocks as t1')->selectRaw("t1.variation_id, t1.retailer_id, t1.quantity as inventory,
                 IF(@sum$index < $quantity AND t1.quantity < $quantity - @sum$index , t1.quantity , $quantity - @sum$index) as quantity,
                 @sum$index := @sum$index + t1.quantity as cumulative, $quantity as required
                 ")
                    ->where('variation_id', $item->id)
                    ->where('quantity', '>', 0)
                    ->crossJoin(DB::raw("(SELECT @sum$index := 0) r"))
                    ->orderByRaw("variation_id, FIELD(IFNULL(`retailer_id`, -1), $nearbyStocks)");
            }, "t")
                ->whereRaw("cumulative - required < inventory")
                ->orderByRaw("FIELD(IFNULL(`retailer_id`, -1), $nearbyStocks)")
                ->join('variations as v', 'v.id', 'variation_id')
                ->join('products as p', 'p.id', 'v.product_id')
                ->leftJoin('retailers as r', 'r.id', 'retailer_id')
                ->select('variation_id', 'cumulative', 'required', 'retailer_id',
                    DB::raw('IFNULL(r.name, "دفتر مرکزی") as retailerName'),
                    'r.address as retailerAddress', 'r.latitude', 'r.longitude',
                    'v.name', 'v.sku', 'p.name as productName', 'p.is_huge', 'quantity', 'inventory',
                    'p.weight', 'p.width', 'p.depth', 'p.height',
                    DB::raw('(CASE WHEN v.special_price_expiration > NOW() THEN v.special_price ELSE v.price END) as price'),
                    DB::raw('(CASE WHEN v.special_price_expiration > NOW() THEN v.price - v.special_price ELSE 0 END) as discount')
                );

            array_push($results, $result);

        }
        $b = array_shift($results);
        foreach ($results as $r) {
            $b->union($r);
        }

        $finalResult = $b->get();

        $deliveryCalculated = $this->calculateDeliveryCost($finalResult->groupBy('retailer_id'));

        return $deliveryCalculated;

//        foreach ($items as $index => $item) {
//            $result = DB::query()->fromSub(function ($q) use ($nearbyStocks, $item, $index) {
//                $quantity = $item->quantity ?? $item->pivot->quantity;
//                $q->from('stocks as t1')->selectRaw("t1.variation_id, @sum$index := @sum$index + t1.quantity as cumulative, $quantity as required,
//                        @retailersSequence$index := CONCAT_WS(',', @retailersSequence$index, IFNULL(t1.retailer_id, -1)) as retailers")
//                    ->where('variation_id', $item->id)
//                    ->where('quantity', '>', 0)
//                    ->crossJoin(\Illuminate\Support\Facades\DB::raw("(SELECT @sum$index := 0) r"))
//                    ->crossJoin(\Illuminate\Support\Facades\DB::raw("(SELECT @retailersSequence$index := NULL) r2"))
//                    ->orderByRaw("variation_id, FIELD(IFNULL(`retailer_id`, -1), $nearbyStocks)");
//            }, "t")
//                ->where('cumulative', '>=', $item->quantity ?? $item->pivot->quantity)
//                ->join('variations as v', 'v.id', 'variation_id')
//                ->join('products as p', 'p.id', 'v.product_id')
//                ->select('variation_id', 'cumulative', 'required',
//                    'retailers', 'v.name', 'v.sku', 'p.name as productName', 'p.is_huge', 'p.delivery_cost',
//                    DB::raw('(CASE WHEN v.special_price_expiration > NOW() THEN v.special_price ELSE v.price END) as price'))
//                ->limit(1);
//            array_push($results, $result);
//        }
//        $b = array_shift($results);
//        foreach ($results as $r) {
//            $b->union($r);
//        }
//        return $b->get();

//        foreach ($items as $index => $item) {
//            $baseTable = DB::table('stocks')
//                ->leftJoin('retailers', 'retailers.id', 'stocks.stock_id')
//                ->join('variations', 'variations.id', 'stocks.variation_id')
//                ->join('products', 'variations.product_id', 'products.id')
//                ->select(['stocks.variation_id', 'stocks.retailer_id', 'variations.name', 'products.is_huge', 'products.delivery_cost',
//                    DB::raw('(CASE WHEN variations.special_price_expiration > NOW() THEN variations.special_price ELSE variations.price END) as price')])
//                ->selectRaw('retailers.latitude, retailers.longitude, retailers.address as retailerAddress, retailers.name as retailerName, retailers.id as retailerId')
//                ->orderByRaw("stocks.variation_id, FIELD(IFNULL(`items`.`stock_id`, -1), $nearbyStocks)");
//
//            $t = "base$index";
//
//            $baseTable->joinSub($baseTable, $t, function ($join) use ($item, $t) {
//                $join->on("$t.id", "items.id")->where("$t.variation_id", $item->id);
//            })->limit($item->quantity ?? $item->pivot->quantity);
//
//            array_push($results, $baseTable);
//        }
//
//        $b = array_shift($results);
//
//        foreach ($results as $r) {
//            $b->union($r);
//        }
//
//        return $b->get();
    }

    private function calculateDeliveryCost($group)
    {
        return $group->mapWithKeys(function ($shipping) {
            $weightCost = $shipping->sum(function ($i) {
                return $i->weight * $i->quantity * 5000;
            });
            $packageCost = $shipping->map(function ($item) {
                return max($item->width, $item->height, $item->depth) > 30 ? 20000 : 10000;
            })->max();
            return [$shipping[0]->retailerName => [
                'items' => $shipping,
                'shippingMethods' => [
                    [
                        'id' => 1,
                        'name' => 'دریافت در محل',
                    ],
                    [
                        'id' => 2,
                        'name' => 'ارسال با پست',
                    ],
                    [
                        'id' => 3,
                        'name' => 'ارسال با باربری',
                    ],
                ],
                'delivery_cost' => $weightCost + $packageCost,
                'retailer_id' => $shipping[0]->retailer_id,
                'retailer_address' => $shipping[0]->retailerAddress,
                'latitude' => $shipping[0]->latitude,
                'longitude' => $shipping[0]->longitude,
            ]];
        });
    }
}