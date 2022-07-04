<?php

namespace App\Traits;

use DateTimeInterface;
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

    public function getPayedAtAttribute($date)
    {
        if ($date)
            return Jalalian::forge($date)->format($this->shamsiFormat);
        return null;
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}