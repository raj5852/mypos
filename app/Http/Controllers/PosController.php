<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    function index(){
        return view('pos.index');
    }
}
