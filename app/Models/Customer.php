<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    function histories()
    {
        return $this->hasManyThrough(History::class, Order::class, 'customer_id', 'historyable_id')
            ->where('historyable_type', 'App\\Models\\Order');
    }

    function orders(){
        return $this->hasMany(Order::class);
    }

    function ScopeReceivable($query){
        $query->withSum('orders as receivable','receivable');
    }

    function ScopePaid($query){
        $query->withSum('histories as paid','amount');
    }

}
