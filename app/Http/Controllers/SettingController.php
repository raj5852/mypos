<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index',compact('setting'));
    }
    function store(Request $request)
    {
        $request->validate([
            'company_name' => ['nullable', 'max:256'],
            'email' => ['nullable', 'max:256'],
            'phone' => ['nullable', 'max:256'],
            'address' => ['nullable', 'max:256'],
        ]);

        Setting::query()->updateOrCreate([
            'id' => 1
        ], [
            'company_name' => request('company_name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'address' => request('address'),
        ]);

        return back()->with('message', 'Updated successfull');
    }
}
