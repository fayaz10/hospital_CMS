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
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('lab.lab_mod')); ?></h3>
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
        <div class="m-portlet__head">
            <div class="m-portlet__head-progress">

                <!-- here can place a progress bar-->
            </div>
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="la la-user"></i>
                        </span>
                        <h3 class="m-subheader__title m-subheader__title--separator">
                            <?php echo e(__('lab.lab_addtest')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="<?php echo e(route('test.index')); ?>"
                        class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span><?php echo e(__('global.gol_back')); ?></span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button"
                            class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span><?php echo e(__('global.gol_save')); ?></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="<?php echo e(route('test.store')); ?>" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title"> <?php echo e(__('lab.lab_info')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">*</span>
                                            <?php echo e(__('lab.lab_test')); ?></label>
                                        <input type="text" value="<?php echo e(old('test_name')); ?>" name="test_name" required
                                            class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"> <span
                                                class="text-danger"></span><?php echo e(__('lab.lab_testDr')); ?></label>
                                        <input type="text" value="<?php echo e(old('test_nameDr')); ?>" name="test_nameDr"
                                            class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><?php echo e(__('lab.lab_testEn')); ?></label>
                                        <input type="text" value="<?php echo e(old('test_nameEn')); ?>" name="test_nameEn"
                                            class="form-control m-input" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><i
                                                class="text-danger">*</i><?php echo e(__('lab.lab_testPrice')); ?></label>
                                        <input type="text" value="<?php echo e(old('test_price')); ?>" name="test_price"
                                            class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i>
                                            <?php echo e(__('reception.docy_currency')); ?></label>
                                        <select class="form-control m-input" name="currency_id">
                                            <?php $__currentLoopData = \App\Models\FinanceModule\Currency::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>">
                                                <?php echo e($type->label_dr); ?> (<?php echo e($type->symbol); ?>)
                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"> <?php echo e(__('lab.lab_duration')); ?></label>
                                        <input type="text" value="<?php echo e(old('test_duration')); ?>" name="test_duration"
                                            class="form-control m-input" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><?php echo e(__('pharmacist.r_range')); ?></label>
                                        <textarea name="detailesDr" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- <script src="<?php echo e(asset('js/select2.min.js')); ?>"></script> -->

<script type="text/javascript">
    // $(document).ready(function () {
    //     $('#modules, #roles').select2({
    //         placeholder: 'لطفا انتخاب نمایید',
    //         tag: true
    //     });
    // });

    $('#save-button').click(function () {
        $('#save-form').submit();
    });

    $(document).ready(function () {
        $(".summernote").summernote({
            height:400,
            toolbar: [
                ['style', ['bold']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ],
        })
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/lab-module/test/create.blade.php ENDPATH**/ ?>