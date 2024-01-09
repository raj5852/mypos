<?php

namespace App\Models;

use App\Trait\ModelData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelData;
    protected $guarded = [];
}
