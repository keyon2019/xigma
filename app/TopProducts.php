<?php

namespace App;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopProducts
{
    public function discounted()
    {
        return Cache::remember('most_discounted_products', 7200, function () {
            return Product::whereDate('special_price_expiration', '>', Carbon::now())
                ->select(DB::raw('*, ((price - IFNULL(special_price, price)) / price) * 100 as discount'))
                ->orderBy('discount', 'desc')->get();
        });
    }

    public function popular($category = null)
    {
        return Cache::remember("most_popular_{$category->name}_products", 14400, function () use ($category) {
            $items = Item::with('variation.product')
                ->select('variation_id', DB::raw('COUNT(variation_id) as count'))
                ->groupBy('variation_id')
                ->orderBy('count', 'desc')
                ->limit(8);
            if ($category) {
                $items->whereHas('variation.product', function ($q) use ($category) {
                    return $q->whereHas('categories', function ($q) use ($category) {
                        return $q->whereIn('id', Category::getAllSubCategoriesIds($category));
                    });
                });
            }
            return $items->get()->pluck('variation')->pluck('product');
        });
    }

    public function newest($category = null)
    {
        if ($category)
            return Cache::remember("newest_{$category->name}_products", 7200, function () use ($category) {
                return $category->withSubCategoryProducts()->latest()->limit(8)->get();
            });
        return Cache::remember('newest__products', 7200, function () {
            return Product::latest()->limit(8)->get();
        });
    }

    public function purge($type, $categoryName = null)
    {
        return Cache::forget(($type === 1 ? "newest_" : "popular_") . $categoryName . "_products");
    }
}