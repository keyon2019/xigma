<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class ReturnReason extends Enum
{
    const DEFECTED = 0;
    const WRONG = 1;

    function keyValues(): array
    {
        return [
            0 => 'کالا را معیوب تحویل گرفتم',
            1 => 'کالای اشتباه ارسال شده است'
        ];
    }
}