<?php if($errors->any()): ?>

<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="la flaticon-exclamation-1"></i>
    </div>
    <div class="m-alert__text">
        <strong>Invalid data given!</strong>.
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/errors/validation-errors.blade.php ENDPATH**/ ?>