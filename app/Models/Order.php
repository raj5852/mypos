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

      // paid
      function scopePaid($query)
      {
          $query->withSum(['histories as paid' => function ($query) {
              $query->where(['type' => '+', 'historyable_type' => 'App\Models\Order']);
          }], 'amount');
      }

}
