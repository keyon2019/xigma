<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 6/19/22
 * Time: 1:51 PM
 */

namespace App\Enum;


use ArrayAccess;

abstract class Enum implements ArrayAccess
{
    abstract function keyValues(): array;

    public function all()
    {
        return $this->keyValues();
    }

    public function json()
    {
        return json_encode($this->keyValues());
    }

    public function __toString()
    {
        return $this->json();
    }

    public function offsetSet($offset, $value) {}

    public function offsetUnset($offset) {}

    public function offsetExists($offset)
    {
        return isset($this->keyValues()[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->keyValues()[$offset];
    }

}