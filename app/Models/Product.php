<?php

namespace App\Models;

use App\Trait\ModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelData;
    protected $guarded = [];

    function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => null
        ]);
    }
    function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault([
            'name' => 'No brand'
        ]);
    }

    function mainunit()
    {
        return $this->belongsTo(Unit::class, 'main_unit');
    }

    function subunit()
    {
        return $this->belongsTo(Unit::class, 'sub_unit');
    }
}
