<?php

namespace App\Services;


use App\Models\Order;
use App\Models\Retailer;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch;

class StockService
{
    public function checkInventory($variationId, $quantity = 1)
    {
        return DB::table('stocks')
            ->where('variation_id', $variationId)
            ->groupBy('variation_id')
            ->selectRaw('SUM(stocks.quantity) as q')
            ->having('q', '>=', $quantity)
            ->exists();
    }

    public function checkInventoryBatch($collection)
    {
        $query = DB::table('variations as v')
            ->whereIn('v.id', $collection->keys())
            ->leftJoin('stocks as s', 's.variation_id', 'v.id')
            ->join('products as p', 'v.product_id', 'p.id')
            ->groupBy('v.id')
            ->selectRaw('v.id as variation_id, COALESCE(SUM(s.quantity), 0) as q, v.*, p.name as productName')
            ->get();

        $result = $query->each(function ($variation) use ($collection) {
            $variation->available = $variation->q >= $collection[$variation->variation_id];
        })->keyBy('variation_id');

        return $result;
    }


    public function supply($variationId)
    {
        return Retailer::rightJoin('stocks', 'id', 'stocks.retailer_id')
            ->selectRaw('retailers.*, IFNULL(retailers.name, "کارخانه") as name ,SUM(stocks.quantity) as quantity')
            ->groupBy('retailers.id')
            ->where('stocks.variation_id', $variationId)
            ->get();
    }

    public function updateInventory(Variation $variation, $quantity, $retailerId = null)
    {
        DB::table('stocks')->updateOrInsert(
            ['variation_id' => $variation->id, 'retailer_id' => $retailerId],
            ['quantity' => $quantity]
        );
    }

    public function updateStocksInventory(Order $order)
    {
        $collection = collect();
        $order->shippings()->with('variations')->get()->each(function ($shipping) use ($collection) {
            foreach ($shipping->variations as $variation) {
                $collection->push([
                    'variation_id' => $variation->id,
                    'retailer_id' => $shipping->stock_id,
                    'quantity' => $variation->pivot->quantity
                ]);
            }
        });
        DB::transaction(function () use ($collection) {
            foreach ($collection as $row) {
                DB::table('stocks')->whereVariationId($row['variation_id'])
                    ->whereRetailerId($row['retailer_id'])
                    ->decrement('quantity', $row['quantity']);
            }
        });
    }
}