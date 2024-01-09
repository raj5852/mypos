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

            <li class="{{ request()->is('units*') ? 'active-page' : '' }}">
                <a href="#"><i class="material-icons-two-tone">ad_units</i>
                    Units<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('units.create') }}" class="{{request()->is('units/create') ? 'active':''}}">Add units</a>
                    </li>
                    <li>
                        <a href="{{ route('units.index') }}" class="{{request()->is('units') ? 'active':''}}">Manage units</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('category*') ? 'active-page' : '' }}">
                <a href="#"><i class="material-icons-two-tone">category</i>
                    Category<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('category.create') }}" class="{{request()->is('category/create') ? 'active':''}}">Add category</a>
                    </li>
                    <li>
                        <a href="{{ route('category.index') }}" class="{{request()->is('category') ? 'active':''}}">Manage category</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('brand*') ? 'active-page' : '' }}">
                <a href="#"><i class="material-icons-two-tone">military_tech</i>
                    Brand<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('brand.create') }}" class="{{request()->is('brand/create') ? 'active':''}}">Add brand</a>
                    </li>
                    <li>
                        <a href="{{ route('brand.index') }}" class="{{request()->is('brand') ? 'active':''}}">Manage brand</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->is('product*') ? 'active-page' : '' }}">
                <a href="#"><i class="material-icons-two-tone">inventory_2</i>
                    product<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('product.create') }}" class="{{request()->is('product/create') ? 'active':''}}">Add product</a>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}" class="{{request()->is('product') ? 'active':''}}">Manage product</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
