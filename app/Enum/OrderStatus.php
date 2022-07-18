<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class OrderStatus extends Enum
{
    const PLACED = 1;
    const INSPECTING = 2;
    const PREPARING = 3;
    const SHIPPED = 4;
    const CANCELED = 5;


    function keyValues(): array
    {
        return [
            '1' => 'ثبت فاکتور',
            '2' => 'بررسی سفارش',
            '3' => 'آماده‌سازی',
            '4' => 'ارسال شد',
            '5' => 'لغو شده'
        ];
    }
}