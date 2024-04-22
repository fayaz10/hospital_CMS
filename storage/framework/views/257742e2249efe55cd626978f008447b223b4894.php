<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('system-admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('admin.adm_mod')); ?> </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text"><?php echo e(__('global.gol_fpage')); ?> </span>
                        </a>
                    </li>
                    <!-- <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">State Colors</span>
                        </a>
                    </li> -->
                </ul>
            </div>
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-6 order-2 order-xl-1">
                        </div>
                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <!----><a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="<?php echo e(url('/admin/module/create')); ?>">
                                <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span> </span> </a>
                            
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table m-table m-table--head-separator-primary">
                    <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('admin.adm_number')); ?></th>
                        <th><?php echo e(__('admin.adm_code')); ?></th>
                        <th><?php echo e(__('admin.adm_path')); ?></th>
                        <th><?php echo e(__('admin.adm_EnName')); ?> </th>
                        <th> <?php echo e(__('admin.adm_FrName')); ?></th>
                        <th> <?php echo e(__('global.operation')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(++$key); ?></td>
                            <td><?php echo e($module->code); ?></td>
                            <td><?php echo e($module->path); ?></td>
                            <td><?php echo e($module->label_en); ?></td>
                            <td><?php echo e($module->label_dr); ?></td>
                            <td>
                                <a href="#">
                                    <i class="flaticon-add"></i>
                                </a>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/system-admin/module/index.blade.php ENDPATH**/ ?>