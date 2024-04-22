<?php $__env->startSection('styles'); ?>
    <!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

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
                    <a href="<?php echo e(route('doctor.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('reception.docy_modul')); ?></span>
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
                        <h3 class="m-portlet__head-text">
                        <?php echo e(__('reception.docy_add')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                        <a href="<?php echo e(route('doctor.index')); ?>"
                           class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span><?php echo e(__('global.gol_back')); ?></span>                                
                            </span>
                        </a>
                        <div class="btn-group">
                            <button type="button"
                                    id="save-button"
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
            <form action="<?php echo e(route('doctor.store')); ?>" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('reception.docy_add')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i><?php echo e(__('reception.docy_name')); ?></label>
                                        <input type="text" value="<?php echo e(old('first_name')); ?>" name="first_name" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">  <i class="text-danger">*</i><?php echo e(__('reception.docy_surname')); ?></label>
                                        <input type="text" value="<?php echo e(old('last_name')); ?>" name="last_name" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i><?php echo e(__('reception.docy_specialze')); ?></label>
                                        <input type="text" value="<?php echo e(old('specialist')); ?>" name="specialist" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i><?php echo e(__('reception.docy_fees')); ?></label>
                                        <input type="number" value="<?php echo e(old('visit_fee')); ?>" name="visit_fee" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                   
                                </div>
                                <div class="form-group m-form__group row">
                                <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i><?php echo e(__('reception.docy_currency')); ?></label>
                                        <select class="form-control m-input" name="currency_id">
                                            <?php $__currentLoopData = \App\Models\FinanceModule\Currency::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>">
                                                    <?php echo e($type->label_dr); ?> (<?php echo e($type->symbol); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label class="form-control-label"><?php echo e(__('profile.user_regis')); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- <label class="m-radio m-radio--single m-radio--state"> -->
                                                        <input type="checkbox" name="make_user">
                                                    <!-- </label> -->
                                                    &nbsp;&nbsp;&nbsp;
                                                        <span><?php echo e(__('profile.user_create')); ?></span>
                                                </span>
                                            </div>
                                            <input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                                        </div>                                    
                                        <span class="m-form__help"><?php echo e(__('profile.user_alert')); ?></span>
                                        
                                    </div>
                              
                                    <div class="col-lg-6">
                                        <label class="form-control-label"><i class="text-danger">*</i><?php echo e(__('profile.prfilePic')); ?></label>
                                        
                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input">
                                            <label class="custom-file-label" for="customFile"><?php echo e(__('profile.user_chosePhoto')); ?></label>
                                        </div>
                                    </div>
                               
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

    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });
        
        form.submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/receptionist-module/doctor/create.blade.php ENDPATH**/ ?>