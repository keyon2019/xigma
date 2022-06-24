<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class ReturnTechnicalStatus extends Enum
{
    const REJECTED = 0;
    const REFUND = 1;
    const REPLACE = 2;

    function keyValues(): array
    {
        return [
            0 => 'عدم تایید مرجوعی',
            1 => 'استرداد وجه',
            2 => 'جایگزینی کالا'
        ];
    }
}