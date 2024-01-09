<?php

namespace App\Trait;

use App\Models\Image;

trait ModelData
{
    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->withDefault([
            'image' => 'assets/images/404.png'
        ]);
    }
}
