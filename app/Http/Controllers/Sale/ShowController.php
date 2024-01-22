<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    function index(int $id)
    {
        $order = Order::query()
            ->where('id', $id)
            ->with(['histories', 'products:id,name,code,main_unit_related_value,main_unit_name,sub_unit_name', 'customer:id,name,phone,address'])
            ->totalsellprice()
            ->paid()
            ->firstOrFail();

        $address = Setting::first();
        return view('sale.show',compact('address','order'));
    }
}
