<?php


namespace App\Services;


use App\Interfaces\CartInterface;

class ShippingService
{
    public const PICKUPATSTORE = 1;
    public const POST = 2;
    public const TRUCK = 3;

    public const CHEAPEST = 1;
    public const FASTEST = 2;

    public const SHIPPING_METHODS = [self::PICKUPATSTORE, self::POST, self::TRUCK];
    public const COST_PREFERENCES = [self::CHEAPEST, self::FASTEST];

    public $closestItemFinderService;

    public function __construct(ClosestItemFinderService $closestItemFinderService)
    {
        $this->closestItemFinderService = $closestItemFinderService;
    }

    public function availableMethods(CartInterface $cart, $cost_preference, $stocks)
    {
        $availableMethods = self::SHIPPING_METHODS;
        if ($cart->hasHugeProduct())
            //If Cart has Huge Product remove Shipping by Bike!
            unset($availableMethods[1]);
        if ($cost_preference == self::CHEAPEST) {
            //If There is a second route which is not the factory or there are more than 2 routes remove pickup at store
            if (count($stocks) > 2 || (count($stocks) > 1 && $stocks[1]->stock_id != null))
                unset($availableMethods[0]);
            return array_values($availableMethods);
        }
        if ($cost_preference == self::FASTEST) {
            if (count($stocks) > 1) {
                //If There is a second route remove pickup at store
                unset($availableMethods[0]);
            }
            return array_values($availableMethods);
        }
        return [];
    }

    public function findStores($address_id, $items, $method = self::CHEAPEST)
    {
        return $this->closestItemFinderService->find($address_id, $items, $method);
    }
}