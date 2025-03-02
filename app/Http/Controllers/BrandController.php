<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!rolecheck(['brand'])) {
            return abort(404);
        }
         $brands = Brand::with('image')
            ->withCount('products')
            ->get();
        return view('brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!rolecheck(['brand'])) {
            return abort(404);
        }
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        if (!rolecheck(['brand'])) {
            return abort(404);
        }
        return view('brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $productsExists = $brand->products()->exists();
        if($productsExists){
            return back()->with('error', 'You can not delete');
        }
        filedelete($brand->image->image);
        $brand->image()->delete();
        $brand->delete();

        return to_route('brand.index')->with('message', 'Brand deleted successfully');
    }
}
