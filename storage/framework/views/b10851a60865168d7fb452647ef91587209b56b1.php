<?php $__env->startSection('styles'); ?>
<!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('lab-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('lab.lab_modTest')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="<?php echo e(route('test.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('lab.lab_modTest')); ?></span>
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">

                        <a href="<?php echo e(route('test.edit', $test->id)); ?>" class="btn btn-secondary">
                            <span>
                                <i class="la la-pencil"></i> <span><?php echo e(__('global.gol_edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('test.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.gol_cret')); ?></span></span>
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
                                <h3 class="m-form__heading-title"> <?php echo e(__('lab.lab_info')); ?></h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('lab.lab_test')); ?> </label>
                                    <p><strong><?php echo e($test->name); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('lab.lab_testDr')); ?></label>
                                    <p><strong><?php echo e($test->label_dr); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('lab.lab_testEn')); ?></label>
                                    <p><strong><?php echo e($test->label_en); ?></strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('lab.lab_detailsDr')); ?> </label>
                                    <p><strong><?php echo e($test->label_en); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('lab.lab_detailsEn')); ?> </label>
                                    <p><strong><?php echo e($test->description_en); ?></strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"> <?php echo e(__('lab.lab_testPrice')); ?> </label>
                                    <p><strong><?php echo e($test->price); ?> <?php echo e(app()->isLocale('en') ? $test->currency->label_en : $test->currency->label_dr); ?></strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"><?php echo e(__('lab.lab_duration')); ?> </label>
                                    <p><strong><?php echo e($test->duration); ?> <?php echo e(__('global.glo_hou')); ?></strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-6">
                                    <label class="form-control-label"><?php echo e(__('global.sub_test_name')); ?> </label><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $test->subTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subTest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <strong><?php echo e(++$key); ?>. <?php echo e($subTest->name); ?></strong><br>
                                        <span ><pre class="ml-5"><?php echo $subTest->range; ?></pre></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.r_range')); ?> </label>
                                    <pre><strong><?php echo nl2br($test->description_dr); ?></strong></pre>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/lab-module/test/show.blade.php ENDPATH**/ ?>