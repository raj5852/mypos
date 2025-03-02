<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use DNS1D;
use DNS2D;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!rolecheck(['product'])) {
            return abort(404);
        }
        $name = request('name', '');
        $code = request('code', '');
        $category_id = request('category_id', '');
        $brand_id = request('brand_id', '');

        $products = Product::query()
            ->latest()
            ->with(['category:id,name', 'brand:id,name'])
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($code, function ($query) use ($code) {
                $query->where('code', 'like', "%{$code}%");
            })
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', "{$category_id}");
            })
            ->when($brand_id, function ($query) use ($brand_id) {
                $query->where('brand_id', "{$brand_id}");
            })
            ->paginate(15)
            ->withQueryString();
        $brands = Brand::get(['id', 'name']);
        $categories = Category::get(['id', 'name']);

        return view('product.index', compact('products', 'brands', 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!rolecheck(['product'])) {
            return abort(404);
        }
        return view('product.create');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!rolecheck(['product'])) {
            return abort(404);
        }
        $product = Product::query()
            ->where('id', $id)
            ->with(['category', 'brand', 'image'])
            ->purchased()
            ->sell()
            ->damage()
            ->firstOrFail();
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (!rolecheck(['product'])) {
            return abort(404);
        }
        return view('product.edit', compact('product'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Product::query()
            ->where('id', $id)
            ->sell()
            ->withCount(['purchasedetails as purchased' => function ($query) {
                $query->where('purchase_id', '!=', '');
            }])
            ->withCount(['damages as damage'])
            ->firstOrFail();

        if ($product->sell  != '' || $product->purchased > 0 || $product->damage > 0) {
            return back()->with('error', 'You can not delete');
        }

        filedelete($product->image->image);
        $product->image()->delete();
        $product->delete();
        return to_route('product.index')->with('message', 'Product deleted successfully');
    }

    function sellhistory($productid)
    {
        if (!rolecheck(['product'])) {
            return abort(404);
        }
        $orderDetails = Product::findOrFail($productid)
            ->orderdetails()
            ->with('product')
            ->latest()
            ->paginate(15);

        return view('product.sellhistory', compact('orderDetails'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    function barcode($productid)
    {
        $product = Product::findOrFail($productid);
        return DNS1D::getBarcodeHTML($product->code, 'C128');
    }

    function qrcode($productid)
    {
        $product = Product::findOrFail($productid);
        return DNS2D::getBarcodeHTML($product->code, 'QRCODE');
    }
}
