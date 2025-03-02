<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!rolecheck(['unit'])) {
            return abort(404);
        }
        $units = Unit::with('relatedtodata:id,unit_name')->get();
        return view('units.index', compact('units'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!rolecheck(['unit'])) {
            return abort(404);
        }
        return view('units.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {

        $unitdata = $unit->relatedtodatas()->exists();
        $mainunitproducts = $unit->mainunitproducts()->exists();
        $subunitproducts = $unit->subunitproducts()->exists();

        if ($unitdata || $mainunitproducts || $subunitproducts) {
            return back()->with('warning', 'You can not delete');
        }
        $unit->delete();


        return back()->with('error', 'Unit deleted successfull');
    }
}
