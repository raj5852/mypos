<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\History;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $today;
    public $current_month;
    public $current_year;

    function __construct()
    {
        $this->today = now()->today();
        $this->current_month = Carbon::now()->month;
        $this->current_year = Carbon::now()->year;
    }
    function index()
    {
        $rolenames = Auth::user()->roles()->pluck('name')->toArray();

        if (!in_array('dashboard', $rolenames)) {
            $rolename = collect($rolenames)->first();
            $url = getRedirectUrl($rolename);
            return redirect($url);
        }

        // Today Summary
        $todaySummeries = $this->todaySummery();

        // Current Month Summary
        $currentMonthSummaries = $this->currentMonthSummaries();

        // total summary
        $totalSummeries = $this->totalSummeries();

        // totalDatas
        $totalDatas = $this->totalDatas();

        // totalValues
        $totalValues = $this->totalValues();

        return view('dashboard', compact('todaySummeries', 'currentMonthSummaries', 'totalSummeries', 'totalDatas', 'totalValues'));
    }

    function todaySummery()
    {
        $todaySold = OrderDetails::whereDate('date', $this->today)->sum('total_sell_price');

        $today_sold_purchase_cost = OrderDetails::whereDate('date', $this->today)->sum('total_purchase_cost');

        $todayPrfit = $todaySold - $today_sold_purchase_cost;

        return [
            'todaySold' => $todaySold,
            'today_sold_purchase_cost' => $today_sold_purchase_cost,
            'todayPrfit' => $todayPrfit,
        ];
    }

    function currentMonthSummaries()
    {
        $current_month_sold = OrderDetails::query()
            ->whereMonth('date', $this->current_month)
            ->whereYear('date', $this->current_year)
            ->sum('total_sell_price');

        $current_month_purchased = PurchaseDetails::whereHas('purchase', function ($query) {
            $query->whereMonth('purchase_date', $this->current_month)->whereYear('purchase_date', $this->current_year);
        })->sum('total_amount');

        $current_month_sell_purchasecost = OrderDetails::query()
            ->whereMonth('date', $this->current_month)
            ->whereYear('date', $this->current_year)
            ->sum('total_purchase_cost');

        $current_month_profit = $current_month_sold - $current_month_sell_purchasecost;

        $currentMonthDatas = [
            'month' => Carbon::now()->format('M'),
            'year' => Carbon::now()->format('Y'),
        ];

        return [
            'current_month_sold' => $current_month_sold,
            'current_month_purchased' => $current_month_purchased,
            'current_month_profit' => $current_month_profit,
            'currentMonthDatas' => $currentMonthDatas,
        ];
    }

    // Total Summary
    function totalSummeries()
    {
        $total_sold = OrderDetails::query()->sum('total_sell_price');

        $total_purchasecost = PurchaseDetails::whereHas('purchase')->sum('total_amount');

        $total_sell_purchasecost = OrderDetails::query()->sum('total_purchase_cost');

        $total_profit = $total_sold - $total_sell_purchasecost;

        return [
            'total_sold' => $total_sold,
            'total_purchasecost' => $total_purchasecost,
            'total_profit' => $total_profit,
        ];
    }

    function totalDatas()
    {
        // Total Receivable
        $receivable = Order::query()->sum('receivable');

        $paid = History::query()
            ->where(['type' => '+', 'historyable_type' => 'App\Models\Order'])
            ->sum('amount');
        $total_receivable = $receivable - $paid;

        // Total Payable
        $purchaseCost = PurchaseDetails::query()->whereHas('purchase')->sum('total_amount');

        $purchaseForPaid = History::query()
            ->where(['historyable_type' => 'App\\Models\\Purchase', 'type' => '-'])
            ->sum('amount');

        $total_payable = $purchaseCost - $purchaseForPaid;

        // Total Banalce
        $banks = BankAccount::query()
            ->withSum(
                [
                    'histories as current_balance' => function ($query) {
                        $query->where('type', '+');
                    },
                ],
                'amount',
            )
            ->withSum(
                [
                    'histories as withdraw' => function ($query) {
                        $query->where('type', '-');
                    },
                ],
                'amount',
            )
            ->get();

        $total_balance = $banks->sum(function ($bank) {
            return ($bank->current_balance ?: 0) - ($bank->withdraw ?: 0);
        });

        return [
            'total_receivable' => $total_receivable,
            'total_payable' => $total_payable,
            'total_balance' => $total_balance,
        ];
    }

    function totalValues()
    {
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        return [
            'totalCustomers' => $totalCustomers,
            'totalSuppliers' => $totalSuppliers,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
        ];
    }
}
