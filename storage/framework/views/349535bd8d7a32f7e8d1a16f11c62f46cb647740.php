<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('finance-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('finance.finance-module')); ?></h3>
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
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-6">
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('income.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('pharmacist.med_number')); ?></th>
                        <th> <?php echo e(__('finance.incSection')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                        <th> <?php echo e(__('finance.paymentDate')); ?></th>
                        <th> <?php echo e(__('finance.paymentRecipient')); ?></th>
                        <th> <?php echo e(__('lab.lab_expCreatedAt')); ?></th>
                        <?php if(!auth()->user()->can('fin_report_to_mof')): ?>
                            <th> <?php echo e(__('global.glo_hou')); ?></th>
                        <?php endif; ?>
                        <th><?php echo e(__('pharmacist.med_operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($incomes->currentPage() == 0 ? 1 :$incomes->currentPage() - 1) * $incomes ->perPage() + $key + 1); ?></td>
                        <td><?php echo e(__('finance.'.strtolower(basename($income->profitable_type, '\\')))); ?></td>
                        <td>
                            <?php echo e($income->totalAmount); ?>

                            <?php echo e(app()->getLocale() == 'en' ? $income->currency->label_en : $income->currency->label_dr); ?>

                        </td>
                        <td><?php echo e($income->payment_date); ?></td>
                        <td><?php echo e($income->recipient); ?></td>
                        <td><?php echo e($income->created_at->format('Y-m-d')); ?></td>
                        <?php if(!auth()->user()->can('fin_report_to_mof')): ?>
                            <td><?php echo e($income->created_at->format('g:i A')); ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="<?php echo e(route('income.show', [$income->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="disabled" href="#">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($incomes->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\New folder\hosys\hosys\resources\views/finance-module/income/index.blade.php ENDPATH**/ ?>