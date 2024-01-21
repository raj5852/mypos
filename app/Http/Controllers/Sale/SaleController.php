<?php

namespace App\Http\Controllers\Sale;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    function index()
    {
        $bill = request('bill');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $customer_id = request('customer_id');
        $product_id = request('product_id');


        $orders = Order::query()
            ->latest()
            ->when($bill, function ($query) use ($bill) {
                $query->where('id', $bill);
            })
            ->when($start_date, function ($query) use ($start_date) {
                $query->where('date', '>=', "{$start_date}");
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->where('date', '<=', "{$end_date}");
            })
            ->when($customer_id, function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })
            ->when($product_id, function ($query) use ($product_id) {
                $query->whereHas('orderDetails', function ($query) use ($product_id) {
                    $query->where('product_id', $product_id);
                });
            })
            ->with(['products:id,name,code,main_unit_related_value,main_unit_name,sub_unit_name','customer'])
            ->paid()
            ->purchecost()
            ->paginate(15)
            ->withQueryString();

        $sales = Customer::get(['id', 'name']);
        $products = Product::get(['id', 'name']);


        return view('sale.index', compact('orders', 'sales', 'products'))
            ->with('i', (request()->input('page', 1) - 1) * 15);;
    }
}
