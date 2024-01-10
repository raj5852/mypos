<?php

namespace App\Trait;

use App\Models\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
trait ModelData
{
    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->withDefault([
            'image' => 'assets/images/404.png'
        ]);
    }

    function scopeSearch(Builder $builder, string $term = "")
    {
        foreach ($this->searchables as $searchable) {
            if (str_contains($searchable, '.')) {

                $relation = Str::beforeLast($searchable, '.');
                $column = Str::afterLast($searchable, '.');

                $builder->orWhereRelation($relation, $column, 'like', "%{$term}%");
                continue;
            }
            $builder->orWhere($searchable, 'like', "%{$term}%");
        }
        return $builder;
    }
}
