<?php if(session()->has('alert')): ?>
<div class="alert <?php echo e(session()->has('class') ? session()->get('class') : 'alert-info'); ?> alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h3>
        <?php echo e(__('global.' . session()->get('alert'))); ?>

    </h3>
    <?php if(session()->has('message')): ?>
    <p>
        <?php echo e(session()->get('message')); ?>

    </p>
    <?php endif; ?>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/errors/alert.blade.php ENDPATH**/ ?>