<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = [];

    function histories()
    {
        return $this->hasManyThrough(History::class, Purchase::class, 'supplier_id', 'historyable_id');
    }

    function purchasedetails(){
        return $this->hasManyThrough(PurchaseDetails::class, Purchase::class);
    }

    function scopePayable($query)
    {
        $query->withSum(['purchasedetails as payable' ], 'total_amount');
    }

    function scopePaid($query)
    {
        $query->withSum(['histories as paid' => function ($query) {
            $query->where(['type' => '-', 'historyable_type' => 'App\\Models\\Purchase']);
        }], 'amount');
    }

    function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
