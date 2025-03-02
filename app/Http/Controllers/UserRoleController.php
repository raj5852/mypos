<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!rolecheck(['user_and_role'])) {
            return abort(404);
        }
        $roles = Role::get(['id','name']);
        $users = User::latest()->whereNot('is_default',1)->paginate(10);
        return view('userrole.index',compact('roles','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role'=>['required','array','min:1'],
            'role.*'=>['exists:roles,id'],
            'name'=>['required'],
            'email'=>['required','unique:users,email','email'],
            'password'=>['required']
        ]);


        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $user->roles()->sync($request->role);

        return redirect()->back()->with('success','User created successfully');
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
        if (!rolecheck(['user_and_role'])) {
            return abort(404);
        }
        $user =  User::query()->whereNot('is_default',1)->findOrFail($id)->load('roles:id');
        $roles = Role::get(['id','name']);

        return view('userrole.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role'=>['required','array','min:1'],
            'role.*'=>['exists:roles,id'],
            'name'=>['required'],
            'email'=>['required','unique:users,email,'.$id,'email'],
            'password'=>['required']
        ]);

        $user = User::query()->whereNot('is_default',1)->findOrFail($id);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $user->roles()->sync($request->role);

        return redirect('userrole')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::whereNot('is_default',1)->findOrFail($id);
        $user->delete();

        return redirect('userrole')->with('success','User deleted successfully');
    }
}
