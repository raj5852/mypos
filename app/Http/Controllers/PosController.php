<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    function index()
    {
        if (!rolecheck(['pos'])) {
            return abort(404);
        }
        return view('pos.index');
    }
}
