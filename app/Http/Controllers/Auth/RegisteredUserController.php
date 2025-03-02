<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // RedirectResponse
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['id'] = $request->domain;
        $validated['domain'] = $request->domain.'.'.getDomainName();

        $tenant =  Tenant::create($validated);
        $tenant->createDomain($tenant->domain);

        return redirect(tenant_route($tenant->domain,'login'));

    }
}
