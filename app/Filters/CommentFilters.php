<?php

namespace App\Filters;


class CommentFilters extends QueryFilter
{
    public function approved($value)
    {
        $this->query->whereApproved($value);
    }
}