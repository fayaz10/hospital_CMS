<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('pharmacist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> <?php echo e(__('pharmacist.med_module')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="<?php echo e(route('medicine.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('global.gol_fpageMed')); ?></span>
                    </a>
                </li>
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('medicine.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        
                        <a href="<?php echo e(route('medicine.edit', $medicine->id)); ?>" class="btn btn-secondary">
                            <span>
                                <i class="la la-pencil"></i> <span><?php echo e(__('global.gol_edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="btn-group">
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('medicine.create')); ?>">
                                <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                                </span>
                            </a>
                            <button type="button" class="btn  btn-focus m-btn--air dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">
                                    <?php echo e(__('global.gol_more_options')); ?>

                                </span>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(80px, 40px, 0px);">
                                <a class="dropdown-item" href="<?php echo e(route('medicine.create') .'?multiple'); ?>">
                                    <?php echo e(__('global.gol_create_multiple')); ?>

                                </a>
                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title"> <?php echo e(__('pharmacist.med_info')); ?></h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_name')); ?> </label>
                                    <p><strong><?php echo e($medicine->name); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_company')); ?></label>
                                    <p><strong><?php echo e($medicine->company); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_milligram')); ?></label>
                                    <p><strong><?php echo e($medicine->milligram); ?></strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.med_type')); ?> </label>
                                    <p><strong>
                                            <?php echo e(app()->isLocale('en') ? $medicine->type->label_en : $medicine->type->label_dr); ?>

                                        </strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_unit')); ?></label>
                                    <p><strong>
                                        <?php echo e(app()->isLocale('en') ? $medicine->unit->label_en : $medicine->unit->label_dr); ?>

                                    </strong></p>
                                </div>

                            </div>

                        </div>
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.med_excist')); ?></h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.med_excist')); ?> </label>
                                    <p><strong>
                                        <?php echo e($medicine->store->quantity); ?>

                                        <?php echo e(app()->isLocale('en') ? $medicine->unit->label_en : $medicine->unit->label_dr); ?>

                                    </strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.med_price')); ?></label>
                                    <p><strong>
                                        <?php echo e($medicine->store->unit_price); ?>

                                        <?php echo e(app()->getLocale() == 'en' ? $medicine->store->currency->label_en : $medicine->store->currency->label_dr); ?>

                                    </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/pharmacist-module/medicine/show.blade.php ENDPATH**/ ?>