<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Setting;
use App\Models\Supplier;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bill = request('bill');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $supplier = request('supplier_id');
        $product_id = request('product_id');

        $purchases = Purchase::query()
            ->latest()
            ->with(['supplier:id,name', 'products:id,name,code'])
            ->payable()
            ->paid()
            ->when($bill, function ($query) use ($bill) {
                $query->where('id', 'like', "%{$bill}%");
            })
            ->when($start_date, function ($query) use ($start_date) {
                $query->where('purchase_date', '>=', "{$start_date}");
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->where('purchase_date', '<=', "{$end_date}");
            })
            ->when($supplier, function ($query) use ($supplier) {
                $query->where('supplier_id', "{$supplier}");
            })
            ->when($product_id, function ($query) use ($product_id) {
                $query->where('id', "{$product_id}");
            })
            ->paginate(15)
            ->withQueryString();

        $suppliers = Supplier::get(['id', 'name']);
        $products = Product::get(['id', 'name']);

        return view('purchase.index', compact('purchases', 'suppliers', 'products'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $purchaseId)
    {
        $purchase =   Purchase::query()
            ->with(['histories', 'supplier', 'products:id,name,code,main_unit,sub_unit' => ['mainunit', 'subunit']])
            ->payable()
            ->paid()
            ->where('id', $purchaseId)
            ->firstOrFail();

        $address = Setting::first();
        return view('purchase.show', compact('address', 'purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function invoice(int $purchaseId)
    {
        $purchase =   Purchase::query()
            ->with(['supplier', 'products:id,name,code,main_unit,sub_unit' => ['mainunit', 'subunit']])
            ->paid()
            ->payable()
            ->where('id', $purchaseId)
            ->firstOrFail();

        $address = Setting::first();

        return view('purchase.invoice', compact('address', 'purchase'));
    }

    function addpayment($id)
    {
        $purchase = Purchase::query()
            ->where('id', $id)
            ->paid()
            ->payable()
            ->firstOrFail();

        $banks = BankAccount::get(['id', 'name']);

        return view('purchase.addpayment', compact('purchase', 'banks'));
    }


    function addpaymentStore(Request $request, $id)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'account' => ['required', 'exists:bank_accounts,id'],
            'amount' => ['required', 'numeric'],
            'note' => ['nullable']
        ]);

        $amount = request('amount');
        $note = request('note');
        $date = request('date');
        $bankId = request('account');
        $purchase = Purchase::findOrFail($id);
        try {
            DB::beginTransaction();

            HistoryService::Transition($purchase, $bankId, $amount, '-', $note, $date);


            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd('wrong');
        }


        return  to_route('purchase.show', $purchase->id)->with('message', 'Payment added successfully');
    }


}
