<?php

namespace App\Livewire\Purchase;

use App\Models\BankAccount;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\HistoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $name, $email, $address, $phone, $opening_receivable, $opening_payable;


    public $supplier_id, $selectedDate, $grand_total = 0, $paying_item = 0, $due = 0, $pay_amount, $note;

    public $addproducts = [];
    public $banks, $bank_account_id;

    public function mount()
    {
        $this->selectedDate = now()->toDateString();
        $this->banks = BankAccount::all();
        $this->bank_account_id = BankAccount::first()?->id;
    }

    public function getproductId($id)
    {
        $product = collect($this->addproducts)->where('id', $id)->first();

        if ($product) {
            $this->dispatch('productexists', 'Product already added');
            return false;
        } else {
            $getproduct = Product::query()->where('id', $id)->with(['mainunit', 'subunit'])->first();


            $this->addproducts[] = [
                'id' => $getproduct->id,
                'name' => $getproduct->name,
                'purchase_cost' => $getproduct->purchase_cost,
                'main_quantity' => 0,
                'sub_quantity' => 0,
                'main_unit_name' => $getproduct->mainunit->unit_name,

                'is_subunit' => $getproduct->sub_unit == null ? false : true,
                'sub_unit_name' => $getproduct->sub_unit == null ? null : $getproduct->subunit->unit_name,
                'related_by_value' => $getproduct->mainunit->related_by_value ?? 1,
                'sub_total' => 0,
            ];
            $this->dispatch('productremove');
            $this->paying_item = count($this->addproducts);
        }
    }

    function updateMainQuantity($index, $value)
    {
        if ($value != '') {
            if (0 > $value) {
                $this->dispatch('wrong');
                return false;
            }
        }

        $this->addproducts[$index]['main_quantity'] = $value ?: 0;
        $this->subtotalupdate($index);
    }

    function updateSubQuantity($index, $value)
    {
        if ($value != '') {
            if (0 > $value) {
                $this->dispatch('wrong');
                return false;
            }
        }

        $this->addproducts[$index]['sub_quantity'] = $value ?: 0;
        $this->subtotalupdate($index);
    }

    function subtotalupdate($index)
    {

        $relatedByValue = $this->addproducts[$index]['related_by_value'];

        $buyPrice = $this->addproducts[$index]['purchase_cost'];
        $mainqty = ($buyPrice * $this->addproducts[$index]['main_quantity']);


        $subqty = ($buyPrice / $relatedByValue) * $this->addproducts[$index]['sub_quantity'];


        $this->addproducts[$index]['sub_total'] = $mainqty + $subqty;

        $this->grand_total = collect($this->addproducts)->sum('sub_total');
        $this->due = $this->grand_total;
    }

    function deleteProduct($index)
    {
        unset($this->addproducts[$index]);
        $this->grand_total = collect($this->addproducts)->sum('sub_total');
        $this->paying_item = count($this->addproducts);
        $this->due = $this->grand_total;
    }

    function updateRate($index, $value)
    {
        if ($value != '') {
            if (filter_var($value, FILTER_VALIDATE_INT) == false) {
                $this->dispatch('wrong');
                return false;
            }
        }

        $this->addproducts[$index]['purchase_cost'] = $value ?: 0;
        $this->subtotalupdate($index);
    }

    function paid()
    {
        $this->pay_amount = $this->grand_total;
        $this->due = 0;
    }

    function payamount($value)
    {

        $this->pay_amount = $value ?: 0;
        $this->due = ($this->grand_total - $this->pay_amount);
    }

    function purchase()
    {
        $this->validate([
            'bank_account_id' => ['required', 'exists:bank_accounts,id']
        ]);
        try {
            DB::beginTransaction();


            $purchase = Purchase::query()->create([
                'supplier_id' => $this->supplier_id,
                'payable' => $this->grand_total,
                'paid' => $this->pay_amount,
                'due' => $this->due,
                'note' => $this->note,
                'purchase_date' => $this->selectedDate
            ]);


            foreach ($this->addproducts as $product) {
                $totalQty = totalunit($product['is_subunit'], $product['main_quantity'], $product['sub_quantity'], $product['related_by_value']);

                $purchase->productpurchases()->create([
                    'product_id' => $product['id'],
                    'qty' => $totalQty,
                    'price' => $product['purchase_cost'],
                ]);

                Product::find($product['id'])->increment('stock', $totalQty);
                Product::find($product['id'])->increment('purchased', $totalQty);
            }

            if ($this->pay_amount != 0) {
                HistoryService::Transition($purchase,$this->bank_account_id,$this->pay_amount,'-',$this->note,$this->selectedDate);
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('wrong');
            return false;
        }
        return to_route('purchase.invoice', $purchase->id);
    }

    function paymentModal()
    {

        $this->pay_amount = 0;
        $this->due = $this->grand_total;
    }


    function supplierStore()
    {
        $this->validate([
            'name' => ['required', 'max:256'],
            'email' => ['nullable', 'unique:suppliers,email'],
            'address' => ['nullable', 'max:2000'],
            'phone' => ['required', 'unique:suppliers,phone'],
            'opening_receivable' => ['nullable', 'numeric'],
            'opening_payable' => ['nullable', 'numeric'],
        ]);

        Supplier::create([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'opening_receivable' => $this->opening_receivable ?: 0,
            'opening_payable' => $this->opening_payable ?: 0,
        ]);

        $this->reset('name', 'email', 'address', 'phone', 'opening_receivable', 'opening_payable');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.purchase.create');
    }
}
