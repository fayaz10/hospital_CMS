<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    <?php echo $__env->make('layouts.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startSection('styles'); ?>
    <?php echo $__env->yieldSection(); ?>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- BEGIN: Header -->
<?php echo $__env->make('layouts.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
    <?php echo $__env->make('layouts.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <?php $__env->startSection('content'); ?>
            <?php echo $__env->yieldSection(); ?>
        </div>
    </div>

    <!-- end:: Body -->

    <!-- start:: Footer -->
    <?php echo $__env->make('layouts.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end:: Footer -->
    
</div>

<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<!-- begin::scripts -->
<!-- <?php echo $__env->make('layouts.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->
<?php echo $__env->make('layouts.includes.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('plugins'); ?>
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo $__env->yieldSection(); ?>

<!-- end:: scripts -->

</body>

<!-- end::Body -->
</html><?php /**PATH C:\MyWebs\New folder\hosys\hosys\resources\views/layouts/app.blade.php ENDPATH**/ ?>