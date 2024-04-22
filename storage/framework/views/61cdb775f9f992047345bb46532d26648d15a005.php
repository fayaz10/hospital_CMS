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
                        <span class="m-nav__link-text"><?php echo e(__('reception.frst_page2')); ?></span>
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
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('doctor.edit', [$doctor->id])); ?>" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span><?php echo e(__('profile.edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="<?php echo e(route('doctor.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active"><?php echo e(__('profile.prfile')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#activities" data-toggle="tab" class="nav-link"><?php echo e(__('profile.activities')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#modules" data-toggle="tab" class="nav-link"><?php echo e(__('global.modules')); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('reception.docy_Info')); ?></h3>
                            </div>
                            <div class="row">
                                <div class="form-group m-form__group">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.docy_name')); ?></u></label>
                                        <p><strong><?php echo e($doctor->first_name); ?> "<?php echo e($doctor->last_name); ?>"</strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('reception.docy_surname')); ?> </u></label>
                                        <p><strong><?php echo e($doctor->specialist); ?> </strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.docy_fees')); ?></u></label>
                                        <p><strong><?php echo e($doctor->visit_fee); ?> <?php echo e($doctor->currency->label_dr); ?></strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.docy_email')); ?></u></label>
                                        <p><strong><?php echo e($doctor->email); ?></strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('profile.user_registrant')); ?></u></label>
                                        <p><strong><?php echo e($doctor->registrar->name); ?>-> <?php echo e($doctor->registrar->email); ?></strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('profile.user_regdate')); ?></u></label>
                                        <p><strong><?php echo e($doctor->created_at); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>

                        <div class="tab-pane" id="activities">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('profile.user_lastActiv')); ?></h3>
                                <p> <strong><?php echo e(__('profile.user_here')); ?></strong></p>
                            </div>
                        </div>

                        <div class="tab-pane" id="modules">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"></h3>
                            </div>
                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('admin.adm_code')); ?></th>
                                        <th><?php echo e(__('admin.adm_EnName')); ?></th>
                                        <th><?php echo e(__('admin.adm_FrName')); ?></th>
                                        <th><?php echo e(__('admin.adm_path')); ?></th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-1 text-center">
                    <img src="<?php echo e(file_exists($doctor->photo) ? asset($doctor->photo) : url('assets/app/media/img/users/user4.jpg')); ?>"
                        class="mx-auto img-fluid img-circle d-block" alt="avatar">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/receptionist-module/doctor/show.blade.php ENDPATH**/ ?>