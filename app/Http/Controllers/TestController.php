<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    function store(Request $request)
    {
        if ($request->hasFile('image')) {
            return $data =  $request->file('image')->store('public');
        }
    }
}
