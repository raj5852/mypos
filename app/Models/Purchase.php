<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];


    function productpurchases(){
        return $this->hasMany(ProductPurchase::class,'purchase_id');
    }

    function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    function products(){
        return $this->belongsToMany(Product::class,'product_purchases')->withPivot(['qty','price']);
    }

    // function purchasepayments(){
    //     return $this->hasMany(PurchasePayment::class,'purchase_id');
    // }
    function histories(){
        return $this->morphMany(History::class,'historyable');
    }
}
