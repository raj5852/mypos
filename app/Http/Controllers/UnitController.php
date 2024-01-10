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
        $units = Unit::with('relatedtodata:id,unit_name')->get();
        return view('units.index', compact('units'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {

        $unitdata = $unit->relatedtodatas()->exists();

        if ($unitdata) {
            return back()->with('warning', 'You can not delete');
        }
        $unit->delete();


        return back()->with('message', 'Unit deleted successfull');
    }
}
