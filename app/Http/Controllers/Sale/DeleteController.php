<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    function addpaymentdelete(int $id){
        $history = History::findOrFail($id);
        $history->delete();

        return back()->with('message','Payment deleted successfully');
    }
}
