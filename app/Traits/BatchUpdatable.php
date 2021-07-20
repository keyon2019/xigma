<?php

namespace App\Traits;

trait BatchUpdatable
{
    public static function updateValues(array $values)
    {
        $model = new self();
        batch()->update($model, $values, 'id');
    }

}