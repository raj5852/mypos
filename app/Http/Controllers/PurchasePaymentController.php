<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    function delete($id){
        $history = History::findOrFail($id);
        $history->delete();

        return back()->with('message','Payment deleted successfully');
    }
}
