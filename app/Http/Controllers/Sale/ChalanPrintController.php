<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChalanPrintController extends Controller
{
    function index(){
        return view('sale.chalanprint');
    }
}
