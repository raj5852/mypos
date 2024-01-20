<?php

namespace App\Models;

use App\Trait\ModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelData;
    protected $guarded = [];

    protected $searchables = ['name', 'code'];

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



    function purchasedetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }


    function orderdetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    function scopePurchased($query)
    {
        $query->withSum(['purchasedetails as purchased'], 'qty');
    }

    function scopeSell($query)
    {
        $query->withSum(['orderdetails as sell'], 'qty');
    }
}
