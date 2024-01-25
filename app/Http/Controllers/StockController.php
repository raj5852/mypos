<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    function index()
    {
        $code = request('code', '');
        $name = request('name', '');
        $category_id = request('category_id', '');
        $brand_id = request('brand_id', '');
        $product_id = request('product_id', '');

        $products = Product::query()
            ->when($code, function ($query) use ($code) {
                $query->where('code', 'like', "%{$code}%");
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', "{$category_id}");
            })
            ->when($brand_id, function ($query) use ($brand_id) {
                $query->where('brand_id', "{$brand_id}");
            })
            ->when($product_id, function ($query) use ($product_id) {
                $query->where('id', "{$product_id}");
            })
            ->with(['category:id,name', 'brand:id,name','mainunit', 'subunit'])
            ->with('image')
            ->purchased()
            ->sell()
            ->damage()
            ->paginate(15);

        $brands = Brand::get();
        $categories = Category::get();

        return view('stock.stock', compact('products', 'brands', 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
}
