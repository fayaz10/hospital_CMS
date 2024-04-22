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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>    
                        <a href="<?php echo e(route('emergency.print', [$emergency->id])); ?>" class="btn btn-secondary">
                            <span> <i class="la la-print"></i> <span><?php echo e(__('global.print')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>  
                        <a href="<?php echo e(route('emergency.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        
                        <a href="<?php echo e(route('emergency.edit', $emergency->id)); ?>" class="btn btn-secondary">
                            <span>
                                <i class="la la-pencil"></i> <span><?php echo e(__('global.gol_edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('emergency.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.gol_create')); ?></span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h4 class="m-form__heading-title"> <strong><?php echo e(__('global.emergency')); ?></strong></h4>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('global.reason')); ?> </label>
                                    <p><strong><?php echo e($emergency->reason); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('reception.amountOfPayament')); ?> </label>
                                    <p><strong><?php echo e($emergency->profit->totalAmount); ?>  <?php echo e($emergency->profit->currency->label_dr); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('reception.pay_tax')); ?></label>
                                    <p><strong><?php echo e($emergency->profit->taxes); ?> <?php echo e($emergency->profit->currency->label_dr); ?> </strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('reception.pat_name')); ?> </label>
                                    <p><strong><?php echo e($emergency->patient_id ? optional($emergency->patient)->name . ' (' . optional($emergency->patient)->record_no .')' : $emergency->patient_name); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('profile.user_registrant')); ?></label>
                                    <p><strong><?php echo e($emergency->registrar->name_dr); ?></strong>
                                    </p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('profile.user_regdate')); ?></label>
                                    <?php
                                        if(app()->getLocale() == 'dr'){
                                        setlocale(LC_TIME, 'fa_IR');
                                        Carbon\Carbon::setLocale('fa');
                                        }
                                    ?>
                                    <p><strong>
                                            <?php echo e($emergency->created_at ? $emergency->created_at->format('Y-m-d h:m A') : ''); ?>

                                            <br>
                                            "<?php echo e($emergency->created_at ? $emergency->created_at->diffForHumans() : ''); ?>"
                                        </strong></p>
                                </div>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.pay_discount')); ?> </label>
                                    <p><strong><?php echo e($emergency->discount ? $emergency->discount . '%' : __('global.gol_no')); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.pay_cardNum')); ?></label>
                                    <p><strong><?php echo e($emergency->membership_id); ?></strong>
                                    </p>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/receptionist-module/emergency/show.blade.php ENDPATH**/ ?>