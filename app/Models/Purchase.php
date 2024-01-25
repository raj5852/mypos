<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];


    function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_details')->withPivot(['qty', 'price']);
    }

    function purchasedetails()
    {
        return $this->hasMany(PurchaseDetails::class, 'purchase_id');
    }

    function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($order) {
            $order->histories()->delete();
        });
    }



    // payable
    function scopePayable($query)
    {
        $query->withSum(['purchasedetails as payable'], 'total_amount');
    }

    // paid
    function scopePaid($query)
    {
        $query->withSum(['histories as paid' => function ($query) {
            $query->where(['type' => '-', 'historyable_type' => 'App\Models\Purchase']);
        }], 'amount');
    }
}
