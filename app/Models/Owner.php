<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    protected $guarded = [];

    function histories(){
        return $this->morphMany(History::class,'historyable');
    }
}
