<?php

namespace App\Livewire\Pos;

use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\HistoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedDate;
    public $selectProducts = [], $grandTotal = 0, $productsearch, $totalItem = 0, $afterDiscount = 0, $discountvalue = null, $pay_amount, $note;

    public $name, $email, $address, $phone, $opening_receivable, $opening_payable;

    public $banks, $selectedBank_id, $customer_id;


    function storeCustomer()
    {
        $validatedData = $this->validate([
            'name' => ['required', 'max:256'],
            'email' => ['nullable', 'unique:customers,email'],
            'address' => ['nullable', 'max:2000'],
            'phone' => ['required', 'unique:customers,phone'],
            'opening_receivable' => ['nullable', 'numeric'],
            'opening_payable' => ['nullable', 'numeric'],
        ]);
        Customer::create($validatedData);
        $this->reset('name', 'email', 'address', 'phone', 'opening_receivable', 'opening_payable');

        $this->dispatch('closeModal');
    }


    function getproductId($id)
    {

        if (SingleProductStock($id) <= 0) {
            $this->dispatch('stock_not_available');
            return false;
        }

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
            'purchase_cost' => $product->purchase_cost,

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

        $main_unit_related_value = $this->selectProducts[$index]['main_unit_related_value'];
        $main_unit = $value;
        $sub_unit = $this->selectProducts[$index]['sub_unit'];

        $selectedTotalQty = subtotalQty($main_unit_related_value, $main_unit, $sub_unit);
        $totalStock = SingleProductStock($this->selectProducts[$index]['id']);

        if ($totalStock < $selectedTotalQty) {
            $this->dispatch('stock_not_available');
            return false;
        }

        $this->selectProducts[$index]['main_qty'] = $value;
        $this->SumSubTotal($index);
    }



    function updateSubQuantity($index, $value)
    {
        $main_unit_related_value = $this->selectProducts[$index]['main_unit_related_value'];
        $main_unit = $this->selectProducts[$index]['main_qty'];
        $sub_unit = $value;

        $selectedTotalQty = subtotalQty($main_unit_related_value, $main_unit, $sub_unit);
        $totalStock = SingleProductStock($this->selectProducts[$index]['id']);



        if ($totalStock < $selectedTotalQty) {
            $this->dispatch('stock_not_available');
            return false;
        }


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
        $price = $product['price'] ?: 0;
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

    function setCustomer($customerid)
    {
        $this->customer_id = $customerid;
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

    function order()
    {
        $this->validate([
            'discountvalue' => ['nullable', 'numeric'],
            'pay_amount' => ['nullable', 'numeric'],
            'selectedBank_id' => ['required', 'exists:bank_accounts,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'selectedDate' => ['date'],
            'note' => ['nullable']
        ]);

        $bankid = $this->selectedBank_id;
        $pay_amount = $this->pay_amount;
        $date = $this->selectedDate;
        $note = $this->note;

        try {
            DB::beginTransaction();

            $order =  Order::create([
                'customer_id' => $this->customer_id,
                'date' => $this->selectedDate,
                'discount' => $this->discountvalue
            ]);

            foreach ($this->selectProducts as  $product) {
                $main_qty = $product['main_qty'] ?: 0;
                $sub_qty = $product['sub_qty'] ?: 0;
                $main_unit_related_value = $product['main_unit_related_value'];
                $purchase_cost = $product['purchase_cost'];

                $qty = subtotalQty($main_unit_related_value, $main_qty, $sub_qty);
                $total_purchase_cost = stockQtyValue($qty, $main_unit_related_value, $purchase_cost);
                $sellprice = $product['price'] ?: 0;
                $total_sell_price = stockQtyValue($qty, $main_unit_related_value, $sellprice);

                $order->orderDetails()->create([
                    'product_id' => $product['id'],
                    'qty' => $qty,
                    'purchase_cost' => $product['purchase_cost'],
                    'total_purchase_cost' => $total_purchase_cost,
                    'sell_price' => $sellprice,
                    'total_sell_price' => $total_sell_price,
                ]);
            }

            HistoryService::Transition($order, $bankid, $pay_amount, '+', $note, $date);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return to_route('pos')->with('message', 'Order successfull');
    }

    function clickPaymentButton()
    {
        $this->discountvalue = null;
        $this->pay_amount = null;
        $this->afterDiscount = $this->grandTotal;
    }
    function mount()
    {
        $this->selectedDate = now()->toDateString();
        $this->banks = BankAccount::get(['id', 'name']);
        $this->selectedBank_id = BankAccount::first()?->id;
    }

    public function render()
    {
        return view('livewire.pos.index', [
            'customers' => Customer::query()->get(['id', 'name', 'phone']),
            'products' => Product::query()
                ->when($this->productsearch, function ($query) {
                    $query->search($this->productsearch);
                })
                ->with('image')
                ->purchased()
                ->sell()
                ->paginate(12)
        ]);
    }
}
