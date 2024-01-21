<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddPayment extends Controller
{
    function index(int $id){
        return view('sale.addpayment');
    }
}
