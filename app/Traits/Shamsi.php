<?php

namespace App\Traits;

use Morilog\Jalali\Jalalian;

trait Shamsi
{
    public $shamsiFormat = 'Y/m/d - H:i';

    public function getCreatedAtAttribute($date)
    {
        if ($date)
            return Jalalian::forge($date)->format($this->shamsiFormat);
        return null;
    }

    public function getUpdatedAtAttribute($date)
    {
        if ($date)
            return Jalalian::forge($date)->format($this->shamsiFormat);
        return null;
    }

    public function getSailedAtAttribute($date)
    {
        if ($date)
            return Jalalian::forge($date)->format($this->shamsiFormat);
        return null;
    }
}