<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

        <li class="m-menu__item  <?php echo e(request()->is('pharmacist') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(url('/pharmacist')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> <?php echo e(__('global.dashboard')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php if (\Entrust::hasRole('phar_purchase')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('pharmacist/medicine-purchase') || request()->is('pharmacist/medicine-purchase/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('medicine-purchase.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> <?php echo e(__('pharmacist.side_medBuyTitle')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::hasRole ?>
        <?php if (\Entrust::hasRole('phar_medicine')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('pharmacist/medicine') || request()->is('pharmacist/medicine/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('medicine.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"> <?php echo e(__('pharmacist.side_medTitle')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::hasRole ?>
        <?php if (\Entrust::hasRole('phar_prescription')) : ?>
        <li class="m-menu__item <?php echo e(request()->is('pharmacist/prescription') || request()->is('pharmacist/prescription/*') ? 'm-menu__item--active' : ''); ?>" aria-haspopup="true">
            <a href="<?php echo e(route('prescription.index')); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-coins"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text"><?php echo e(__('pharmacist.side_prescription')); ?></span>
                    </span>
                </span>
            </a>
        </li>
        <?php endif; // Entrust::hasRole ?>
        
    </ul>
</div><?php /**PATH C:\wamp64\www\hosys\hosys\hosys\resources\views/pharmacist-module/partials/sidebar.blade.php ENDPATH**/ ?>