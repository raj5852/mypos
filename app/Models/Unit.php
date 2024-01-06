<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];

    function relatedtodata()
    {
        return $this->belongsTo(Unit::class, 'related_to_unit')->withDefault([
            'unit_name' => null
        ]);
    }

    function relatedtodatas()
    {
        return $this->hasMany(Unit::class, 'related_to_unit');
    }
}
