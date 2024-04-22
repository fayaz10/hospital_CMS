<?php $__env->startSection('content'); ?>

<div class="m-content">

    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">پروفایل</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#messages" data-toggle="tab" class="nav-link">تبدیل رمز</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#edit" data-toggle="tab" class="nav-link">ویرایش</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h5 class="mb-3">پروفایل کاربر</h5>
                            <div class="row">
                                <div class="form-group m-form__group">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> اسم کاربر </u></label>
                                        <p><strong><?php echo e($user->name_dr); ?> "<?php echo e($user->name); ?>"</strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> ایمیل کاربر </u></label>
                                        <p><strong><?php echo e($user->email); ?></strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> حالت کاربر </u></label>
                                        <p><strong><?php echo e($user->status ? 'فعال' : 'غیر فعال'); ?> </strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> راجستر کننده </u></label>
                                        <p><strong><?php echo e($user->registrar->name); ?>-> <?php echo e($user->registrar->email); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                        <div class="tab-pane" id="messages">
                            <form role="form" method="post"
                                action="<?php echo e(route('profile.change', [encrypt(auth()->id())])); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">رمز عبور</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="old_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">رمز جدید</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">تکرار رمز</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="تبدیل رمز">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="edit">
                            <form role="form" method="post"
                                enctype="multipart/form-data" 
                                action="<?php echo e(route('profile.update', [encrypt(auth()->id())])); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">اسم کاربر(انگلیسی)</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name" type="text" value="<?php echo e($user->name); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">اسم کاربر (دری)</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name_dr" type="text" value="<?php echo e($user->name_dr); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">ایمیل آدرس</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="email" type="email" value="<?php echo e($user->email); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">انتخاب عکس</label>
                                    <div class="col-lg-9">

                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="ذخیره">
                                        <input type="reset" class="btn btn-secondary" value="کنسل">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/profile/index.blade.php ENDPATH**/ ?>