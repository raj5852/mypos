<?php

namespace App\Livewire\Damage;

use App\Models\Damage;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{

    public $selectedDate;
    public $productId, $main_unit_name, $sub_unit_name, $main_unit_value, $sub_unit_value, $note;


    function mount()
    {
        $this->selectedDate = now()->toDateString();
    }


    function getproductId(int $id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $id;
        $this->main_unit_name = $product->main_unit_name;
        $this->sub_unit_name = $product->sub_unit_name;
    }

    function storeDamage()
    {
        $this->validate([
            'selectedDate' => ['required', 'date'],
            'main_unit_value' => ['required', 'numeric', 'min:0'],
            'sub_unit_value' => ['nullable', 'min:0', 'numeric'],
            'note' => ['nullable'],
        ]);

        $product = Product::findOrFail($this->productId);

        $qty = subtotalQty($product->main_unit_related_value, $this->main_unit_value, $this->sub_unit_value);

        $totalStockQty = SingleProductStock($this->productId);
        if ($qty > $totalStockQty) {
            $this->dispatch('stock_not_available');
            return false;
        }

        Damage::create([
            'product_id' => $this->productId,
            'qty' => $qty,
            'date' => $this->selectedDate,
            'note' => $this->note
        ]);

        return to_route('damage.index');
    }

    public function render()
    {
        return view('livewire.damage.create');
    }
}
