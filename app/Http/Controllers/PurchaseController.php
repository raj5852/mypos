<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Setting;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::query()
            ->latest()
            ->with(['supplier:id,name', 'products:id,name,code'])
            ->paginate(15);
        return view('purchase.index', compact('purchases'))
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
        $purchase =   Purchase::with(['purchasepayments','supplier', 'products:id,name,code,main_unit,sub_unit' => ['mainunit', 'subunit']])->where('id', $purchaseId)->firstOrFail();
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
        $purchase =   Purchase::with(['supplier', 'products:id,name,code,main_unit,sub_unit' => ['mainunit', 'subunit']])->where('id', $purchaseId)->firstOrFail();
        $address = Setting::first();
        return view('purchase.invoice', compact('address', 'purchase'));
    }
}
