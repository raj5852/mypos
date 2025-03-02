<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!rolecheck(['supplier'])) {
            return abort(404);
        }
        $name = request('name', '');
        $phone = request('phone', '');
        $suppliers = Supplier::query()
            // ->latest()
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($phone, function ($query) use ($phone) {
                $query->where('phone', 'like', "%{$phone}%");
            })

            ->paid()
            ->payable()
            ->paginate(15)
            ->withQueryString();

        return view('supplier.index', compact('suppliers'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!rolecheck(['supplier'])) {
            return abort(404);
        }
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierStoreRequest $request)
    {
        $validatedData = $request->validated();
        Supplier::create($validatedData);

        return to_route('supplier.index')->with('message', 'Supplier created successfully');
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
    public function edit(Supplier $supplier)
    {
        if (!rolecheck(['supplier'])) {
            return abort(404);
        }
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $customer = Supplier::findOrFail($id);
        $customer->update($validatedData);

        return to_route('supplier.index')->with('message', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $data = $supplier->purchases()->exists();
        if($data){
            return back()->with('error', 'You can not delete');
        }

        $supplier->delete();
        return back()->with('message', 'Supplier deleted successfully');
    }
}
