<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item  {{ request()->is('finance') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ url('/finance') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{__('global.dashboard')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @role('fin_income')
        <li class="m-menu__item {{ request()->is('finance/income') || request()->is('finance/income/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('income.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{__('finance.sideIncomeList')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole
        @role('fin_expense')
        <li class="m-menu__item {{ request()->is('finance/expense') || request()->is('finance/expense/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
            <a href="{{ route('expense.index') }}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{__('finance.sideExpenseList')}}</span>
                    </span>
                </span>
            </a>
        </li>
        @endrole

        <li class="m-menu__item m-menu__item--submenu m-menu__item--hover {{ (request()->is('finance/diverse-income') || request()->is('finance/diverse-income/*') || request()->is('finance/diverse-expense') || request()->is('finance/diverse-expense/*'))? 'm-menu__item--open' :'' }}" aria-haspopup="true" m-menu-submenu-toggle="hover" data-hover="1" data-timeout="122">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-text">{{__('finance.sideDiverse')}}</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu " m-hidden-height="80" style="{{ !(request()->is('finance/diverse-income') || request()->is('finance/diverse-income/*')  || request()->is('finance/diverse-expense') || request()->is('finance/diverse-expense/*')) ? 'display: none; overflow: hidden;' :'' }}">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                        <span class="m-menu__link">
                            <span class="m-menu__link-text">{{__('finance.sideDiverse')}}</span>
                        </span>
                    </li>
                    @role('fin_d-income')
                    <li class="m-menu__item {{ request()->is('finance/diverse-income') || request()->is('finance/diverse-income/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('diverse-income.index') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{__('finance.sideDiverseIncome')}}</span>
                        </a>
                    </li>
                    @endrole
                    @role('fin_d-expense')
                    <li class="m-menu__item {{ request()->is('finance/diverse-expense') || request()->is('finance/diverse-expense/*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('diverse-expense.index') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{__('finance.sideDiverseExpense')}}</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </div>
        </li>
    </ul>
</div>