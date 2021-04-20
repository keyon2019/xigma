<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $request, $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query)
    {
        $this->query = $query;

        foreach ($this->filters() as $key => $value) {
            if (method_exists($this, $key) && $value != '') {
                call_user_func_array([$this, $key], array_filter([$value]));
            }
        }

        return $this->query;
    }

    public function filters()
    {
        return $this->request->all();
    }

}