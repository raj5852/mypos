<?php

namespace App\Http\Controllers;

use App\Models\Damage;
use App\Models\Product;
use Illuminate\Http\Request;

class DamageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $product = request('product_id');
        $code = request('code');


        $damages = Damage::query()
            ->latest('date')
            ->with('product')
            ->when($code, function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('code', request('code'));
                });
            })
            ->when($product, function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('id', request('product_id'));
                });
            })
            ->paginate(15);

        $products = Product::all();

        return view('damage.index', compact('damages', 'products'))
            ->with('i', (request()->input('page', 1) - 1) * 15);;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('damage.create');
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
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        $damage = Damage::query()->findOrFail($id);
        $damage->delete();

        return back()->with('message', 'Damage deleted successfully');
    }
}
