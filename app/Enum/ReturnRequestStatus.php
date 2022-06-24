<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class ReturnRequestStatus extends Enum
{
    const WAITING = 0;
    const INSPECTING = 1;
    const PREPARING = 2;
    const WAITING_FOR_ADDRESS = 3;
    const RETURNED = 4;
    const FINANCIAL_INSPECTION = 5;
    const REFUNDED = 6;
    const REJECTED = 7;

    function keyValues(): array
    {
        return [
            0 => 'در انتظار دریافت داغی',
            1 => 'در حال بررسی فنی',
            2 => 'در حال آماده‌سازی',
            3 => 'در انتظار ثبت آدرس',
            4 => 'کالا مرجوع شد',
            5 => 'در حال بررسی مالی',
            6 => 'وجه پرداخت شد',
            7 => 'عدم تایید درخواست'
        ];
    }
}