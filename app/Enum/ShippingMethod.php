<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class ShippingMethod extends Enum
{
    const PICKUP_AT_STORE = 1;
    const POST = 2;
    const TRUCK = 3;

    function keyValues(): array
    {
        return [
            '1' => 'دریافت در محل',
            '2' => 'پست',
            '3' => 'باربری'
        ];
    }
}