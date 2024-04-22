<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('pharmacist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('pharmacist.med_module')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"> <?php echo e(__('global.gol_fpage')); ?></span>
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
                        <a href="<?php echo e(route('surpres.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="<?php echo e(route('surpres.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('pharmacist.med_number')); ?></th>
                        <th> <?php echo e(__('reception.vis_patent')); ?></th>
                        <th> <?php echo e(__('reception.vis_record')); ?></th>
                        <th> <?php echo e(__('global.issue_date')); ?></th>
                        <th> <?php echo e(__('pharmacist.pre_medicine_quantity')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                        <th> <?php echo e(__('admin.adm_state')); ?></th>
                        <th><?php echo e(__('global.approval')); ?></th>
                        <th><?php echo e(__('pharmacist.med_operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pres): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($prescriptions->currentPage() == 0 ? 1 :$prescriptions->currentPage() - 1) * $prescriptions ->perPage() + $key + 1); ?>

                        </td>
                        <td><?php echo e($pres->patient->name); ?></td>
                        <td><?php echo e($pres->patient->record_no); ?></td>
                        <td><?php echo e($pres->date); ?>

                            </td>
                        <td><?php echo e($pres->medicines_count); ?> <?php echo e(__('pharmacist.pres_items')); ?></td>
                        <td>
                            <?php echo e($pres->profit->totalAmount); ?>

                            <?php echo e(app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr); ?>

                        </td>
                        <td>
                            <?php
                                $status = optional($pres->approve)->map(function ($item, $key) {
                                    if ($item->is_approved === 1)
                                        return '<span class="text-success la la-check"></span>';

                                    if ($item->is_approved === null)
                                        return '<span class="text-info la la-minus"></span>';

                                    if ($item->is_approved === 0)
                                        return '<span class="text-danger la la-close"></span>';
                                    
                                });
                                
                                echo implode(' ', optional($status)->toArray())
                            ?>
                        </td>
                        <td>
                            <span class="m-badge <?php echo e($pres->is_approved ? 'm-badge--brand' : 'm-badge--danger'); ?> m-badge--wide">
                                <?php echo e($pres->is_approved ? __('global.received') : __('global.pending')); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('surpres.show', [$pres->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo e(route('surpres.edit', $pres->id)); ?>">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($prescriptions->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/pharmacist-module/surpres/index.blade.php ENDPATH**/ ?>