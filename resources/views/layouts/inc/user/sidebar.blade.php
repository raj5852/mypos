@php
       $roles = App\Models\Role::query()->pluck('name')->toArray();
       $userRoles = Auth::user()->roles()->pluck('name')->toArray();
@endphp

<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('dashboard') }}" class="logo-icon"><span class="logo-text">POS</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{ asset('assets/images/user.jpg')}}">
                <span class="activity-indicator"></span>
                <span class="user-info-text">Digital  <br><span class="user-state-info">POS </span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">

            @if (!empty(array_intersect(['bank', 'owner', 'dashboard'], $userRoles)))
                <li class="sidebar-title">
                    Apps
                </li>
            @endif

            @if (in_array('dashboard', $userRoles))
                <li class="{{ request()->is('dashboard') ? 'active-page' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
                </li>
            @endif

            @if (in_array('owner', $userRoles))
                <li  class="{{ request()->is('owner*') ? 'active-page' : '' }}">
                    <a href="{{ route('owner.index') }}"><i class="material-icons-two-tone">person</i>Owner</a>
                </li>
            @endif

            @if (in_array('bank', $userRoles))
                <li  class="{{ request()->is('bank*') ? 'active-page' : '' }}">
                    <a href="{{ route('bank.index') }}"><i class="material-icons-two-tone">account_balance</i>Bank</a>
                </li>
            @endif


            @if (!empty(array_intersect(['pos', 'sales', 'purchase','stock','damage'], $userRoles)))
                <li class="sidebar-title">
                    SALE & PURCHASE
                </li>
            @endif

            @if (in_array('pos', $userRoles))
                <li  class="{{ request()->is('pos') ? 'active-page' : '' }}">
                    <a href="{{ route('pos') }}"><i class="material-icons-two-tone">shopping_cart</i>POS</a>
                </li>
            @endif

            @if (in_array('sales', $userRoles))
                <li  class="{{ request()->is('sale*') ? 'active-page' : '' }}">
                    <a href="{{ route('sale') }}"><i class="material-icons-two-tone">local_mall</i>Sales</a>
                </li>
            @endif


            @if (in_array('purchase', $userRoles))
                <li class="{{ request()->is('purchase*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">liquor</i>
                        Purchase<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('purchase.create') }}"
                                class="{{ request()->is('purchase/create') ? 'active' : '' }}">Add purchase</a>
                        </li>
                        <li>
                            <a href="{{ route('purchase.index') }}" class="{{ request()->is('purchase') ? 'active' : '' }}">Manage
                                purchase</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (in_array('stock', $userRoles))
                <li  class="{{ request()->is('stock') ? 'active-page' : '' }}">
                    <a href="{{ route('product.stock') }}"><i class="material-icons-two-tone">inventory</i>Stock</a>
                </li>
            @endif

            @if (in_array('damage', $userRoles))
                <li class="{{ request()->is('damage*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">broken_image</i>
                        Damages<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('damage.create') }}"
                                class="{{ request()->is('damage/create') ? 'active' : '' }}">Add damage</a>
                        </li>
                        <li>
                            <a href="{{ route('damage.index') }}" class="{{ request()->is('damage') ? 'active' : '' }}">Manage
                                damages</a>
                        </li>
                    </ul>
                </li>
            @endif


            @if (!empty(array_intersect(['unit', 'product', 'category','brand'], $userRoles)))
                <li class="sidebar-title">
                    PRODUCT INFORMATION
                </li>
            @endif

            @if (in_array('unit', $userRoles))
                <li class="{{ request()->is('units*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">ad_units</i>
                        Units<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('units.create') }}"
                                class="{{ request()->is('units/create') ? 'active' : '' }}">Add units</a>
                        </li>
                        <li>
                            <a href="{{ route('units.index') }}" class="{{ request()->is('units') ? 'active' : '' }}">Manage
                                units</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (in_array('product', $userRoles))
                <li class="{{ request()->is('product*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">inventory_2</i>
                        product<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('product.create') }}"
                                class="{{ request()->is('product/create') ? 'active' : '' }}">Add product</a>
                        </li>
                        <li>
                            <a href="{{ route('product.index') }}"
                                class="{{ request()->is('product') ? 'active' : '' }}">Manage product</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (in_array('category', $userRoles))
                <li class="{{ request()->is('category*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">category</i>
                        Category<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('category.create') }}"
                                class="{{ request()->is('category/create') ? 'active' : '' }}">Add category</a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}"
                                class="{{ request()->is('category') ? 'active' : '' }}">Manage category</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (in_array('brand', $userRoles))
                <li class="{{ request()->is('brand*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">military_tech</i>
                        Brand<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('brand.create') }}"
                                class="{{ request()->is('brand/create') ? 'active' : '' }}">Add brand</a>
                        </li>
                        <li>
                            <a href="{{ route('brand.index') }}"
                                class="{{ request()->is('brand') ? 'active' : '' }}">Manage
                                brand</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (!empty(array_intersect(['customer', 'supplier'], $userRoles)))
                <li class="sidebar-title">
                    PEOPLES
                </li>
            @endif

            @if (in_array('customer', $userRoles))
                <li class="{{ request()->is('customer*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">groups</i>
                        Customers<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('customer.create') }}"
                                class="{{ request()->is('customer/create') ? 'active' : '' }}">Add customer</a>
                        </li>
                        <li>
                            <a href="{{ route('customer.index') }}"
                                class="{{ request()->is('customer') ? 'active' : '' }}">Manage
                                customer</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (in_array('customer', $userRoles))
                <li class="{{ request()->is('supplier*') ? 'active-page' : '' }}">
                    <a href="#"><i class="material-icons-two-tone">manage_accounts</i>
                        Suppliers<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu" style="display: none;">
                        <li>
                            <a href="{{ route('supplier.create') }}"
                                class="{{ request()->is('supplier/create') ? 'active' : '' }}">Add supplier</a>
                        </li>
                        <li>
                            <a href="{{ route('supplier.index') }}"
                                class="{{ request()->is('supplier') ? 'active' : '' }}">Manage
                                supplier</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (!empty(array_intersect(['setting', 'user_and_role'], $userRoles)))
                <li class="sidebar-title">
                    SETTING & CUSTOMIZE
                </li>
            @endif

            @if (in_array('setting', $userRoles))
                <li  class="{{ request()->is('setting') ? 'active-page' : '' }}">
                    <a href="{{ route('setting.index') }}"><i class="material-icons-two-tone">settings</i>Setting</a>
                </li>
            @endif

            @if (in_array('user_and_role', $userRoles))
                <li  class="{{ request()->is('userrole*') ? 'active-page' : '' }}">
                    <a href="{{ route('userrole.index') }}"><i class="material-icons-two-tone">groups</i>User and Roles</a>
                </li>
            @endif


            <li class="{{ request()->is('logout') ? 'active-page' : '' }}">
                <a href="{{ route('logout') }}"><i class="material-icons-two-tone">logout</i>Logout</a>
            </li>

        </ul>
    </div>
</div>
