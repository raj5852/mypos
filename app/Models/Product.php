<?php

namespace App\Models;

use App\Trait\ModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelData;
    protected $guarded = [];
    protected $appends = [
        'total_purchased',
        'available_stock'
    ];

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



    function getTotalPurchasedAttribute()
    {
        if ($this->subunit != '') {
            $value = $this->purchased;
            $unitvalue = $this->mainunit->related_by_value;

            $mainunit =  ($value / $unitvalue);
            $firstUnitvalue = floor($mainunit);

            $maindata  = $unitvalue * $firstUnitvalue;
            $lastUnitValue   = $value - $maindata;

            return $firstUnitvalue . ' ' . $this->mainunit->unit_name . ' ' . $lastUnitValue . ' ' . $this->subunit->unit_name;
        } else {
            return $this->purchased . ' ' . $this->mainunit->unit_name;
        }
    }

    function getAvailableStockAttribute()
    {
        if ($this->subunit != '') {
            $value = $this->stock;
            $unitvalue = $this->mainunit->related_by_value;

            $mainunit =  ($value / $unitvalue);
            $firstUnitvalue = floor($mainunit);

            $maindata  = $unitvalue * $firstUnitvalue;
            $lastUnitValue   = $value - $maindata;

            return $firstUnitvalue . ' ' . $this->mainunit->unit_name . ' ' . $lastUnitValue . ' ' . $this->subunit->unit_name;
        } else {
            return $this->stock . ' ' . $this->mainunit->unit_name;
        }
    }
}
