<?php

namespace App\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $name, $code, $category_id, $brand_id, $main_unit, $main_unit_name,  $sub_unit, $sub_unit_value,
        $stock, $sub_stock, $sale_price, $purchase_cost, $details, $image;

    function productstore()
    {
        $this->validate([
            'name' => ['required', 'max:256'],
            'code' => ['nullable', 'unique:products,code', 'max:30'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'main_unit' => ['required', 'exists:units,id'],
            'sub_unit' => ['nullable', 'exists:units,id'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:999999999999999'],
            'sub_stock' => ['nullable', 'integer', 'min:0', 'max:999999999999999'],
            'sale_price' => ['required', 'numeric', 'min:0', 'max:999999999999999'],
            'purchase_cost' => ['required', 'numeric', 'min:0', 'max:999999999999999'],
            'details' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);
        $product = new Product();
        $product->name = $this->name;
        $product->code = $this->code;
        $product->category_id = $this->category_id;
        $product->brand_id = $this->brand_id;
        $product->main_unit = $this->main_unit;
        $product->sub_unit = $this->sub_unit;

        $relatedvalue = Unit::find($this->main_unit)->related_by_value;

        if ($relatedvalue != '') {
            $mainunit = $this->stock * $relatedvalue;
        } else {
            $mainunit = $this->stock;
        }

        if ($this->sub_stock) {
            $mainunit += $this->sub_stock;
        }
        $product->stock = $mainunit;
        $product->sale_price = $this->sale_price;
        $product->purchase_cost = $this->purchase_cost;
        $product->details = $this->details;
        $product->save();

        if ($this->image) {
            $product->image()->create([
                'image' => uploadimage($this->image, 'product/')
            ]);
        }

        return to_route('product.index')->with('message', 'Product created successfully');
    }

    public function render()
    {

        $categories = Category::get(['id', 'name']);
        $brands = Brand::get(['id', 'name']);
        $units = Unit::get(['id', 'unit_name']);

        if ($this->main_unit) {
            $mainunit =  Unit::find($this->main_unit);
            $this->main_unit_name = $mainunit->unit_name;
            $subunits = Unit::where('id', $mainunit?->related_to_unit)->get();
            if ($mainunit?->related_to_unit == null) {
                $this->sub_unit = null;
                $this->stock = null;
                $this->sub_stock = null;
            }
        } else {
            $subunits = [];
        }

        if ($this->sub_unit) {
            $subunit =  Unit::find($this->sub_unit);
            $this->sub_unit_value = $subunit?->unit_name;
        }

        if ($this->main_unit == '') {
            $this->main_unit_name =  null;
            $this->sub_unit =  null;
            $this->sub_unit_value =  null;
        }

        if ($this->sub_unit == '') {
            $this->sub_unit =  null;
            $this->sub_unit_value =  null;
            $this->stock = null;
            $this->sub_stock = null;
        }


        return view('livewire.product.create', [
            'categories' => $categories,
            'units' => $units,
            'brands' => $brands,
            'subunits' => $subunits
        ]);
    }
}
