<?php

namespace App\Traits;

use App\Models\Picture;

trait HasGallery
{
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'picturable');
    }
}