<?php

namespace App\Livewire\Purchase;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $name, $email, $address, $phone, $opening_receivable, $opening_payable;


    public $selectedDate, $grand_total = 0, $paying_item = 0, $due = 0, $pay_amount, $note;

    public $addproducts = [];

    public function mount()
    {
        $this->selectedDate = now()->toDateString();
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
            if (filter_var($value, FILTER_VALIDATE_INT) == false) {
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
            if (filter_var($value, FILTER_VALIDATE_INT) == false) {
                $this->dispatch('wrong');
                return false;
            }
        }

        $this->addproducts[$index]['sub_quantity'] = $value ?: 0;
        $this->subtotalupdate($index);
    }

    function subtotalupdate($index)
    {
        $mainqty = $this->addproducts[$index]['main_quantity'];
        $relatedByValue = $this->addproducts[$index]['related_by_value'];
        $buyPrice = $this->addproducts[$index]['purchase_cost'];
        $subqty = $this->addproducts[$index]['sub_quantity'];


        $totalQty = ($mainqty * $relatedByValue) + $subqty;

        $this->addproducts[$index]['sub_total'] = $totalQty * $buyPrice;

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

    function purchase(){

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
