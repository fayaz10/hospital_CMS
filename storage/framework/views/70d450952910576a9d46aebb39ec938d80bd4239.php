<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('system-admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">مادیول شاگردان</h3>
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
                        <?php echo e(__('profile.user_new')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
            <form action="<?php echo e(url('/admin/user')); ?>" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('profile.full_info')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* <?php echo e(__('profile.user_regis')); ?></label>
                                        <input type="text" ngModel name="email" required class="form-control m-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label"> <?php echo e(__('global.gol_pass')); ?></label>
                                        <input type="password" ngModel name="password" class="form-control m-input"
                                            placeholder="Fill a password of min 8 letters or leave blank to set default password.">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">* <?php echo e(__('admin.adm_EnName')); ?></label>
                                        <input type="text" ngModel name="name" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">* <?php echo e(__('admin.adm_FrName')); ?></label>
                                        <input type="text" ngModel name="name_dr" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* <?php echo e(__('profile.prfilePic')); ?></label>
                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input">
                                            <label class="custom-file-label" for="customFile"><?php echo e(__('profile.user_photo')); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12"> 
                                        <label class="form-control-label"><?php echo e(__('admin.usr_access2')); ?></label>
                                        <select name="modules[]" id="modules" multiple class="form-control m-input">
                                            <?php $__currentLoopData = \App\Models\SystemAdmin\Module::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($module->id); ?>"><?php echo e($module->label_en); ?> ->
                                                <?php echo e($module->label_dr); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12"> 
                                        <label class="form-control-label"><?php echo e(__('admin.usr_decreas')); ?></label>
                                        <select name="roles[]" id="roles" multiple class="form-control m-input">
                                            <?php $__currentLoopData = \App\Models\SystemAdmin\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->label_en); ?> ->
                                                <?php echo e($role->label_dr); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
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
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#modules, #roles').select2({
            placeholder: 'لطفا انتخاب نمایید',
            tag: true
        });
    });

    $('#save-button').click(function () {
        $('#save-form').submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/system-admin/user/create.blade.php ENDPATH**/ ?>