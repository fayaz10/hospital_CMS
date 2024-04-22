<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
     m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item  <?php echo e(request()->is('lab') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('lab.dashboard')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.dashboard')); ?></span>
                    </span>
                </span>
            </a>
        </li>
<?php if (\Entrust::hasRole('lab_experiment')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('lab/experiment') || request()->is('lab/experiment/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('experiment.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-user-ok"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('lab.lab_experiments')); ?></span>
                    </span>
                </span>
            </a>
        </li>
<?php endif; // Entrust::hasRole ?>
<?php if (\Entrust::hasRole('lab_test')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('lab/test') || request()->is('lab/test/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('test.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-avatar"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('lab.lab_list')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::hasRole ?>
        <li class="m-menu__item <?php echo e(request()->is('lab/sub-test') || request()->is('lab/sub-test/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('sub-test.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-avatar"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('global.sub_test')); ?></span>
                    </span>
                </span>
            </a>
        </li>
    </ul>
</div><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/lab-module/partials/sidebar.blade.php ENDPATH**/ ?>