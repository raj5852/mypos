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

            <li class="">
                <a href="#"><i class="material-icons-two-tone">ad_units</i>
                    Units<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('units.create') }}" class="">Add units</a>
                    </li>
                    <li>
                        <a href="{{ route('units.index') }}" class="">Manage units</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
