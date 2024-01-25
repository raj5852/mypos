<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    function delete($id)
    {
        $history = History::findOrFail($id);
        $history->delete();

        return back()->with('message', 'Payment deleted successfully');
    }
    function deletePurchase($id)
    {

        $purchase =  Purchase::query()->findOrFail($id);
        $orderdetails =   $purchase->purchasedetails;


        foreach ($orderdetails as $orderdetail) {

            $product =   Product::query()
                ->where('id', $orderdetail->product_id)
                ->purchased()
                ->sell()
                ->firstOrFail();
            $currentQty = ($product->purchased - $product->sell);
            $subtractionCurrentQty = ($currentQty - $orderdetail->qty);
            if ($subtractionCurrentQty < 0) {
                return back()->with('error', 'You can not delete it.');
            }
        }
        $purchase->delete();
        return back()->with('Success', 'Purchase deleted successfully');
    }
}
