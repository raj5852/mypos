<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $guarded = [];


    function order(){
        return $this->belongsTo(Order::class,'historyable_id');
    }

    function bank(){
        return $this->belongsTo(BankAccount::class,'bank_account_id');
    }

}
