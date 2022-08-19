<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:54 PM
 */

namespace App\Enum;


class Role extends Enum
{
    const OPERATOR = 0;
    const SUPPORT = 1;
    const STOCK = 2;

    function keyValues(): array
    {
        return [
            0 => 'اپراتور',
            1 => 'پشتیبانی',
            2 => 'انبار'
        ];
    }
}