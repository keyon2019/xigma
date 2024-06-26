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
                    'r.address as retailerAddress', 'r.latitude', 'r.longitude', DB::raw('IFNULL(v.points, 0) as points'),
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
    }

    private function calculateDeliveryCost($group)
    {
        return $group->mapWithKeys(function ($shipping) {
            $weightCost = $shipping->sum(function ($i) {
                return $i->weight * $i->quantity * 5;
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