<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    function history()
    {
        return $this->morphOne(History::class, 'historyable');
    }


    function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('qty', 'sell_price', 'total_sell_price');
    }

    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($order) {
            $order->histories()->delete();
        });
    }


    #####################
    // scope
    #####################

    // paid
    function scopePaid($query)
    {
        $query->withSum(['histories as paid' => function ($query) {
            $query->where(['type' => '+', 'historyable_type' => 'App\Models\Order']);
        }], 'amount');
    }

    function scopeTotalsellprice($query)
    {
        return $query->withSum('orderDetails as totalsellprice', 'total_sell_price');
    }

    function scopePurcheCost($query)
    {
        return $query->withSum('orderDetails as purchecost', 'total_purchase_cost');
    }
}
