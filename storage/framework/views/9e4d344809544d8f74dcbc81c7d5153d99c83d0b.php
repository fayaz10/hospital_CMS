<?php $__env->startSection('styles'); ?>
<!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->
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
                        <span class="m-nav__link-text"><?php echo e(__('global.gol_fpage')); ?></span>
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
                        <?php if($user->blocked_at): ?>
                            <a class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air"
                                href="<?php echo e(url('/admin/user/status/'. $user->id)); ?>">
                                <span> <i class="la la-eye"></i> <span><?php echo e(__('global.active')); ?></span>
                                </span>
                            </a>
                        <?php else: ?>
                            <a class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air"
                                href="<?php echo e(url('/admin/user/status/'. $user->id)); ?>">
                                <span> <i class="la la-eye-slash"></i> <span><?php echo e(__('global.deactive')); ?></span>
                                </span>
                            </a>
                            <a href="<?php echo e(url('/admin/user/' . $user->id . '/edit')); ?>" class="btn btn-secondary">
                                <span> <i class="la la-pencil"></i> <span><?php echo e(__('profile.edit')); ?></span> </span> </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                href="<?php echo e(url('/admin/user/create')); ?>">
                                <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <?php if($user->blocked_at): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <h3>
                                This user disabled.
                            </h3>
                            <h3>
                                این کاربر مسدود گردیده است و دیگر نمیتواند وارد سیستم شود.
                            </h3>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
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
                            <a href="" data-target="#modules" data-toggle="tab" class="nav-link"><?php echo e(__('admin.adm_modules')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#roles" data-toggle="tab" class="nav-link"><?php echo e(__('admin.adm_rolls')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#messages" data-toggle="tab" class="nav-link"><?php echo e(__('profile.change_pass')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#edit" data-toggle="tab" class="nav-link"><?php echo e(__('profile.edit')); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('profile.full_info')); ?></h3>
                            </div>
                            <div class="row">
                                <div class="form-group m-form__group">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('admin.usr_name')); ?></u></label>
                                        <p><strong><?php echo e($user->name_dr); ?> "<?php echo e($user->name); ?>"</strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('admin.usr_mail')); ?> </u></label>
                                        <p><strong><?php echo e($user->email); ?></strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('admin.usr_stat')); ?> </u></label>
                                        <p><strong><?php echo e($user->status ? 'فعال' : 'غیر فعال'); ?> </strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('profile.user_registrant')); ?> </u></label>
                                        <p><strong><?php echo e($user->registrar->name); ?>-> <?php echo e($user->registrar->email); ?></strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('profile.user_regdate')); ?></u></label>
                                        <p><strong><?php echo e($user->created_at); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>

                        <div class="tab-pane" id="activities">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('profile.user_lastActiv')); ?></h3>
                            </div>
                        </div>

                        <div class="tab-pane" id="modules">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('profile.user_access')); ?></h3>
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
                                    <?php $__currentLoopData = $user->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$key); ?></th>
                                        <td><?php echo e($module->code); ?></td>
                                        <td><?php echo e($module->label_en); ?></td>
                                        <td><?php echo e($module->label_dr); ?></td>
                                        <td><?php echo e($module->path); ?></td>
                                        <td><i class="flaticon-remove"></i></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="roles">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('profile.user_rolls')); ?></h3>
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
                                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$key); ?></th>
                                        <td><?php echo e($role->name); ?></td>
                                        <td><?php echo e($role->label_en); ?></td>
                                        <td><?php echo e($role->label_dr); ?></td>
                                        <td><?php echo e($role->description); ?></td>
                                        <td><i class="flaticon-remove"></i></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="messages">
                            <form role="form" method="post"
                                action="<?php echo e(url('admin/user/' . $user->id .'/reset')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('profile.user_newPass')); ?></label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('profile.user_repeat')); ?></label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="<?php echo e(__('profile.change_pass')); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="edit">
                            <form role="form" method="post" enctype="multipart/form-data"
                                action="<?php echo e(url('admin/user/' . $user->id )); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('admin.adm_EnName')); ?></label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name" type="text" value="<?php echo e($user->name); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('admin.adm_FrName')); ?></label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name_dr" type="text"
                                            value="<?php echo e($user->name_dr); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('global.gol_mail')); ?></label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="email" type="email"
                                            value="<?php echo e($user->email); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"><?php echo e(__('profile.user_chosePhoto')); ?></label>
                                    <div class="col-lg-9">

                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="<?php echo e(__('global.gol_save')); ?>">
                                        <input type="reset" class="btn btn-secondary" value="<?php echo e(__('global.gol_cancel')); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-1 text-center">
                    <img src="<?php echo e(file_exists(auth()->user()->img_path) ? asset(auth()->user()->img_path) : url('assets/app/media/img/users/user4.jpg')); ?>"
                        class="mx-auto img-fluid img-circle d-block" alt="avatar">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/system-admin/user/show.blade.php ENDPATH**/ ?>