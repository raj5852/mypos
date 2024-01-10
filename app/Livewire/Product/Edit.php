<?php

namespace App\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $id, $name, $code, $category_id, $brand_id, $sale_price, $purchase_cost, $details, $oldimage, $image;

    function mount($product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->code = $product->code;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->sale_price = $product->sale_price;
        $this->purchase_cost = $product->purchase_cost;
        $this->details = $product->details;
        $this->oldimage = $product->image->image;
    }

    function updateProduct()
    {
        $this->validate([
            'name' => ['required', 'max:256'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'purchase_cost' => ['required', 'numeric', 'min:0', 'max:999999999999999'],
            'sale_price' => ['required', 'numeric', 'min:0', 'max:999999999999999'],
            'details' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);

        $product = Product::find($this->id);
        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->brand_id = $this->brand_id;
        $product->purchase_cost = $this->purchase_cost;
        $product->sale_price = $this->sale_price;
        $product->details = $this->details;
        $product->save();

        if ($this->image) {
            filedelete($this->oldimage);
            $product->image()->delete();

            $product->image()->create([
                'image' => uploadimage($this->image, 'product/')
            ]);
        }

        return to_route('product.index')->with('message', 'Product updated successfully');
    }

    public function render()
    {
        $categories = Category::get(['id', 'name']);
        $brands = Brand::get(['id', 'name']);

        return view('livewire.product.edit', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
