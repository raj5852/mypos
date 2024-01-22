<?php

use App\Models\History;
use App\Models\Order;
use App\Models\OrderDetails;

// today product sold
if (!function_exists('SoldToday')) {
    function SoldToday()
    {
        $today = now()->today();
        $todaySold =  Order::query()
            ->whereDate('date', $today)
            ->sum('receivable');

        return formatBalance($todaySold);
    }
}

// today product received
if (!function_exists('TodayReceived')) {
    function TodayReceived()
    {
        $today = now()->today();
        $todayReceived =  History::query()
            ->whereDate('date', $today)
            ->where(['historyable_type' => 'App\Models\Order', 'type' => '+'])
            ->whereHas('order')
            ->sum('amount');

        return formatBalance($todayReceived);
    }
}

if (!function_exists('TodayProfit')) {
    function TodayProfit()
    {
        $today = now()->today();
        $purchaseCost = OrderDetails::query()
            ->whereDate('date', $today)
            ->sum('total_purchase_cost');

        $total_sell_price = OrderDetails::query()
            ->whereDate('date', $today)
            ->sum('total_sell_price');

        return formatBalance($total_sell_price - $purchaseCost);
    }
}
// total sold
if (!function_exists('totalSold')) {
    function totalSold()
    {
        $totalSold =  Order::query()
            ->sum('receivable');

        return formatBalance($totalSold);
    }
}

if (!function_exists('orderDue')) {
    function orderDue($orderid)
    {

        $order = Order::query()
            ->where('id', $orderid)
            ->totalsellprice()
            ->paid()
            ->firstOrFail();

        $grandTotal = ($order->totalsellprice - $order->discount);
        return formatBalance($grandTotal - $order->paid);
    }
}
