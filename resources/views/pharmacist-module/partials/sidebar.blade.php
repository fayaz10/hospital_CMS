<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item  {{ request()->is('pharmacist') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/pharmacist') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> {{__('global.dashboard')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @role('phar_purchase')
        <li class="m-menu__item {{ request()->is('pharmacist/medicine-purchase') || request()->is('pharmacist/medicine-purchase/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('medicine-purchase.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> {{__('pharmacist.side_medBuyTitle')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole
        @role('phar_medicine')
        <li class="m-menu__item {{ request()->is('pharmacist/medicine') || request()->is('pharmacist/medicine/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('medicine.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> {{__('pharmacist.side_medTitle')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole
        @role('phar_prescription')
        <li class="m-menu__item {{ request()->is('pharmacist/prescription') || request()->is('pharmacist/prescription/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('prescription.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{__('pharmacist.side_prescription')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole
        {{-- @role('phar_surgery_prescription')
        <li class="m-menu__item {{ request()->is('pharmacist/surpres') || request()->is('pharmacist/surpres/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('surpres.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{__('global.side_surpres')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole --}}
    </ul>
</div>