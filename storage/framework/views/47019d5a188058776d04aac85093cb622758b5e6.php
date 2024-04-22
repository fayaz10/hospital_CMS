<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
     m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item  <?php echo e(request()->is('receptionist') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(url('/receptionist')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.dashboard')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php if (\Entrust::can('rec_doc_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/doctor') || request()->is('receptionist/doctor/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('doctor.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-user-ok"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.gol_docy')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>
        <?php if (\Entrust::can('rec_pat_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/patient') || request()->is('receptionist/patient/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('patient.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-avatar"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.gol_pat')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>
        <?php if (\Entrust::can('rec_vis_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/visit') || request()->is('receptionist/visit/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('visit.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-list-3"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.gol_vis')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>

        <?php if (\Entrust::can('rec_apr_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/approval') || request()->is('receptionist/approval/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('approval.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.approvals')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>

        <?php if (\Entrust::can('rec_emr_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/emergency') || request()->is('receptionist/emergency/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('emergency.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-alert"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.emergency')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>

        <?php if (\Entrust::can('fin_din_*')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('receptionist/din') || request()->is('receptionist/din/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('din.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                </i>
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text"><?php echo e(__('finance.sideDiverseIncome')); ?></span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::can ?>

        
        <?php if (\Entrust::can('rec_rep_*')) : ?>
        <li class="m-menu__item m-menu__item--submenu m-menu__item--hover <?php echo e(request()->is('receptionist/reports') || request()->is('receptionist/reports/*') ? 'm-menu__item--open' :''); ?>" aria-haspopup="true" m-menu-submenu-toggle="hover" data-hover="1" data-timeout="122">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon la la-bar-chart"></i>
                <span class="m-menu__link-text"><?php echo e(__('global.reports')); ?></span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu " m-hidden-height="80" style="<?php echo e(!(request()->is('receptionist/reports') || request()->is('receptionist/reports/daily')) ? 'display: none; overflow: hidden;' :''); ?>">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                        <span class="m-menu__link">
                            <span class="m-menu__link-text"><?php echo e(__('global.reports')); ?></span>
                        </span>
                    </li>
                    <li class="m-menu__item <?php echo e(request()->is('receptionist/reports/daily') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
                        <a href="<?php echo e(route('reports.daily')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?php echo e(__('global.dailyReports')); ?></span>
                        </a>
                    </li>
                    <li class="m-menu__item <?php echo e(request()->is('receptionist/reports') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
                        <a href="<?php echo e(route('reports.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?php echo e(__('global.proReports')); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php endif; // Entrust::can ?>
    </ul>
</div><?php /**PATH C:\xampp\htdocs\hosys\resources\views/receptionist-module/partials/sidebar.blade.php ENDPATH**/ ?>