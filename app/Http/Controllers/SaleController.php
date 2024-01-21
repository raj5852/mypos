<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    function index()
    {
        $orders = Order::query()
            ->latest()
            ->with('orderDetails')
            ->paid()
            ->purchecost()
            ->paginate(15);

        return view('sale.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 15);;
    }
}
