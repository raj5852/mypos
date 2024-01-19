<?php

namespace App\Livewire\Pos;

use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedDate;
    public $selectProducts = [], $grandTotal = 0, $productsearch, $totalItem = 0, $afterDiscount = 0, $discountvalue = null, $pay_amount;

    public $name, $email, $address, $phone, $opening_receivable, $opening_payable;

    function getproductId($id)
    {
        $product = Product::find($id);

        $exists =  collect($this->selectProducts)->where('id', $product->id)->first();
        if ($exists) {
            $this->dispatch('product_already_added');
            return false;
        }

        $this->selectProducts[] = [
            'id' => $product->id,
            'name' => $product->name . ' - ' . $product->code,
            'quantity' => '',
            'price' => $product->sale_price,
            'main_qty' => '',
            'sub_qty' => '',
            'sub_total' => null,


            'main_unit' => $product->main_unit,
            'sub_unit' => $product->sub_unit,
            'main_unit_name' => $product->main_unit_name,
            'sub_unit_name' => $product->sub_unit_name,
            'main_unit_related_value' => $product->main_unit_related_value
        ];
        $this->grandTotal();
    }

    function search($data)
    {
        $this->productsearch = $data;
    }

    function resetproductsearch()
    {
        $this->productsearch = null;
    }


    function updateMainQuantity($index, $value)
    {
        $this->selectProducts[$index]['main_qty'] = $value;
        $this->SumSubTotal($index);
    }

    function updateSubQuantity($index, $value)
    {
        $this->selectProducts[$index]['sub_qty'] = $value;
        $this->SumSubTotal($index);
    }

    function updatePrice($index, $value)
    {
        $this->selectProducts[$index]['price'] = $value;
        $this->SumSubTotal($index);
    }

    function SumSubTotal($index)
    {
        $product = $this->selectProducts[$index];
        $price = $product['price'];
        $main_qty = $product['main_qty'];
        $sub_qty = $product['sub_qty'];
        $main_unit_related_value = $product['main_unit_related_value'];

        $totalQty = subtotalQty($main_unit_related_value, $main_qty, $sub_qty);
        $PerproductPrice = $price / ($main_unit_related_value ?: 1);
        $this->selectProducts[$index]['sub_total'] = formatBalance($totalQty * $PerproductPrice);
        $this->grandTotal = collect($this->selectProducts)->sum('sub_total');

        $this->grandTotal();
    }

    function deleteProduct($index)
    {
        unset($this->selectProducts[$index]);
        $this->grandTotal();
    }

    function grandTotal()
    {
        $this->grandTotal = collect($this->selectProducts)->sum('sub_total');
        $this->totalItem = collect($this->selectProducts)->count();
        $this->afterDiscount = collect($this->selectProducts)->sum('sub_total');
    }

    function discount($value)
    {

        $this->discountSum();
    }


    function discountSum()
    {

        $total = $this->grandTotal ?: 0;
        $perPercent =  $total / 100;
        $this->afterDiscount = $total - ($perPercent * ($this->discountvalue ?: 0));

        $this->afterDiscount = ($this->afterDiscount - ($this->pay_amount ?: 0));
    }




    function payamount($value)
    {
        $this->discountSum();
    }

    function paid()
    {

        $total = $this->grandTotal ?: 0;
        $perPercent =  $total / 100;
        $discountAmount  = $total - ($perPercent * ($this->discountvalue ?: 0));
        $this->pay_amount = $discountAmount;
        $this->discountSum();
    }

    function order(){
        $this->validate([
            'discountvalue'=>['nullable','numeric'],
            'pay_amount'=>['nullable','numeric'],
        ]);



    }
    function mount()
    {
        $this->selectedDate = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.pos.index', [
            'customers' => Customer::query()->get(['id', 'name', 'phone']),
            'products' => Product::query()
                ->when($this->productsearch, function ($query) {
                    $query->search($this->productsearch);
                })
                ->with('image')->stock()->paginate(12)
        ]);
    }
}
