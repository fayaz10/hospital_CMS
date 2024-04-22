<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
     m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item {{ request()->is('admin') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/admin') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{ __('global.dashboard') }}</span>
                    </span>
                </span>
            </a>
        </li>

        <li class="m-menu__item {{ request()->is('admin/module') || request()->is('admin/module/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/admin/module') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{ __('admin.adm_modules') }}</span>
                    </span>
                </span>
            </a>
        </li>

        <li class="m-menu__item {{ request()->is('admin/user') || request()->is('admin/user/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/admin/user') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-users"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{ __('admin.adm_users') }}</span>
                    </span>
                </span>
            </a>
        </li>

        <li class="m-menu__item {{ request()->is('admin/role') || request()->is('admin/role/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/admin/role') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-list-3"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{ __('admin.adm_rolls') }}</span>
                    </span>
                </span>
            </a>
        </li>

        

    </ul>
</div>