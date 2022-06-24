<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class ReturnEnquiry extends Enum
{
    const REPLACE = 0;
    const REFUND = 1;

    function keyValues(): array
    {
        return [
            0 => 'درخواست کالای جایگزین دارم',
            1 => 'درخواست استرداد مبلغ کالا را دارم'
        ];
    }
}