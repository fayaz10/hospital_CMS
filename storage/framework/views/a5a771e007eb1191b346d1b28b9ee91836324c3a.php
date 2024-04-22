
                                
                                
                                

<!-- end::Body -->





<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>NF Info-Tech</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });

    </script>

    <!--end::Web font -->

    <link href="<?php echo e(asset('assets/vendors/base/vendors.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('assets/demo/default/base/style.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Farsi Fonts -->
    <link href="<?php echo e(asset('css/saleh-farsi-font.css')); ?>" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
            id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper" style="padding-top:10%;">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="<?php echo e(asset('img/isys-logo-o.png')); ?>" class="img-fluid">
                                </a>
                            </div>
                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">ورود به سیستم</h3>
                                </div>
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger">
                                        <?php echo e(session('error')); ?>

                                    </div>
                                <?php endif; ?>
                                <form class="m-login__form m-form" method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input text-center" type="email"
                                            value="<?php echo e(old('email')); ?>" required placeholder="یوزر یا ایمیل آدرس"
                                            name="email">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last text-center"
                                            type="password" placeholder="رمز عبور" required name="password">
                                    </div>
                                    <?php if($errors): ?>
                                    <div class="row m-login__form-sub">
                                        <ul>
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li> <?php echo e($error); ?> </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <div class="col m--align-left m-login__form-left">

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit"
                                            class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ورود</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center"
                style="background-image: url(./img/login-background.png)">
                
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <script src="<?php echo e(asset('assets/vendors/base/vendors.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/demo/default/base/scripts.bundle.js')); ?>" type="text/javascript"></script>

    <!--end::Page Snippets -->
</body>

<!-- end::Body -->

</html>
<?php /**PATH C:\xampp\htdocs\hosys\resources\views/auth/login.blade.php ENDPATH**/ ?>