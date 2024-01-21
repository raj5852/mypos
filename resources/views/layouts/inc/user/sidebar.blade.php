<div class="app-sidebar">
    <div class="logo">
        <a href="index.html" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="/assets/images/avatars/avatar.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text">Raj<br><span class="user-state-info">Kumar</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Apps
            </li>
            <li>
                <a href="index.html"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
            </li>

            <li  class="{{ request()->is('owner*') ? 'active-page' : '' }}">
                <a href="{{ route('owner.index') }}"><i class="material-icons-two-tone">person</i>Owner</a>
            </li>

            <li  class="{{ request()->is('bank*') ? 'active-page' : '' }}">
                <a href="{{ route('bank.index') }}"><i class="material-icons-two-tone">account_balance</i>Bank</a>
            </li>

            <li class="sidebar-title">
                SALE & PURCHASE
            </li>

            <li  class="{{ request()->is('pos') ? 'active-page' : '' }}">
                <a href="{{ route('pos') }}"><i class="material-icons-two-tone">shopping_cart</i>POS</a>
            </li>

            <li  class="{{ request()->is('sale*') ? 'active-page' : '' }}">
                <a href="{{ route('sale') }}"><i class="material-icons-two-tone">local_mall</i>Sales</a>
            </li>

            <li  class="{{ request()->is('stock') ? 'active-page' : '' }}">
                <a href="{{ route('product.stock') }}"><i class="material-icons-two-tone">inventory</i>Stock</a>
            </li>

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




            <li class="sidebar-title">
                PRODUCT INFORMATION
            </li>
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
            <li class="sidebar-title">
                PEOPLES
            </li>

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
            <li class="sidebar-title">
                SETTING & CUSTOMIZE
            </li>
            <li  class="{{ request()->is('setting') ? 'active-page' : '' }}">
                <a href="{{ route('setting.index') }}"><i class="material-icons-two-tone">settings</i>Setting</a>
            </li>


        </ul>
    </div>
</div>
