<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::query()

            ->withSum(['histories as invested' => function ($query) {
                $query->where('type', '+');
            }], 'amount')

            ->withSum(['histories as withdrawn' => function ($query) {
                $query->where('type', '-');
            }], 'amount')

            ->get();

        return view('owner.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:256'],
            'phone' => ['nullable', 'max:20'],
            'address' => ['nullable', 'max:2000'],
        ]);
        Owner::create($request->all());

        return to_route('owner.index')->with('message', 'Owner created successfully');
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
    public function edit(Owner $owner)
    {
        return view('owner.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'name' => ['required', 'max:256'],
            'phone' => ['nullable', 'max:20'],
            'address' => ['nullable', 'max:2000'],
        ]);
        $owner->update($request->all());
        return to_route('owner.index')->with('message', 'Owner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ownerid)
    {
        $owner = Owner::query()
            ->where('id', $ownerid)
            ->withCount('histories')
            ->firstOrFail();

        if ($owner->histories_count > 0) {
            return back()->with('error', 'You can not delete');
        }

        $owner->delete();

        return back()->with('message', 'Owner deleted successfully');
    }

    function invested(int $id)
    {
        $owner = Owner::query()->findOrFail($id);
        $investhistories = $owner->invest()
            ->latest()
            ->with('bank:id,name')
            ->paginate(15);

        return view('owner.investhistory', compact('investhistories'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
    function withdraw(int $id)
    {
        $owner = Owner::query()->findOrFail($id);
        $withdrawhistories = $owner->withdraw()
            ->latest()
            ->with('bank:id,name')
            ->paginate(15);

        return view('owner.withdrawhistory', compact('withdrawhistories'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
}
