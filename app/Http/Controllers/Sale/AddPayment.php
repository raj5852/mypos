<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Order;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class AddPayment extends Controller
{
    function index(int $orderid)
    {
        Order::findOrFail($orderid);
        $banks = BankAccount::get(['id', 'name']);
        return view('sale.addpayment', compact('banks', 'orderid'));
    }

    function store(Request $request)
    {
        $request->validate([
            'orderid' => ['required', 'exists:orders,id'],
            'date' => ['required', 'date'],
            'bank' => ['required', 'exists:bank_accounts,id'],
            'amount' => ['required', 'numeric', 'min:0', function ($attibute, $value, $fail) {
                if ($value) {
                    $orderDue = orderDue(request('orderid'));
                    if ($orderDue < $value) {
                        $fail('Over Payment not Alowed! Due is ' . $orderDue . ' Tk');
                    }
                    if ($value == 0) {
                        $fail('Amount need to be greater than 0');
                    }
                }
            }],
            'note' => ['nullable'],
        ]);
        $orderid = $request->orderid;
        $bankid = $request->bank;
        $pay_amount = $request->amount;
        $note = $request->note;
        $date = $request->date;

        $order = Order::findOrFail($orderid);
        HistoryService::Transition($order, $bankid, $pay_amount, '+', $note, $date);

        return to_route('sale.show',$orderid)->with('message', 'Payment add successfully');
    }
}
