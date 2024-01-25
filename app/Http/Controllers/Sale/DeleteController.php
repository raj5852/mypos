<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Order;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    function addpaymentdelete(int $id){
        $history = History::findOrFail($id);
        $history->delete();

        return back()->with('message','Payment deleted successfully');
    }
    function delete($id){
        $order = Order::findOrFail($id);
        $order->delete();
        return back()->with('message','Order Deleted Successfully');
    }
}
