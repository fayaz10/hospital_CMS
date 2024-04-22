<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('receptionist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('reception.rec_modul')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('reception.frst_page')); ?></span>
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
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                    <i class="la la-plus m--hide"></i>
                    <i class="la la-ellipsis-h"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <?php if (\Entrust::can('rec_doc_show')) : ?>
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-8 col-lg-7">
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <a href="<?php echo e(route('emergency.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <?php if (\Entrust::can('rec_doc_create')) : ?>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('emergency.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <?php endif; // Entrust::can ?>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('global.number')); ?></th>
                        <th><?php echo e(__('global.reason')); ?></th>
                        <th><?php echo e(__('reception.pat_name')); ?></th>
                        <th><?php echo e(__('reception.pay_tax')); ?></th>
                        <th><?php echo e(__('reception.amountOfPayament')); ?>

                        <th><?php echo e(__('reception.pay_discount')); ?>

                        <th><?php echo e(__('global.operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($list->currentPage() == 0 ? 1 :$list->currentPage() - 1) * $list ->perPage() + $key + 1); ?></td>
                        <td><?php echo e($item->reason); ?></td>
                        <td><?php echo e($item->patient_id ? optional($item->patient)->name . ' (' . optional($item->patient)->record_no .')' : $item->patient_name); ?></td>
                        <td><?php echo e($item->profit->taxes); ?> <?php echo e($item->profit->currency->label_dr); ?> </td>
                        <td><?php echo e($item->profit->totalAmount); ?> <?php echo e($item->profit->currency->label_dr); ?> </td>
                        <td><?php echo e($item->discount ? $item->discount . '%' : '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('emergency.show', [$item->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if (\Entrust::can('rec_doc_edit')) : ?>
                            <a href="<?php echo e(route('emergency.edit', $item->id)); ?>">
                                <i class="flaticon-edit"></i>
                            </a>
                            <?php endif; // Entrust::can ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($list->links()); ?>

        </div>
        <?php endif; // Entrust::can ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/receptionist-module/emergency/index.blade.php ENDPATH**/ ?>