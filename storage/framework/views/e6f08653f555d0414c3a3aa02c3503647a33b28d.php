<meta charset="utf-8" />
<title>NF-Info-Tech</title>
<meta name="description" content="Latest updates and statistic charts">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

<!--begin::Web font -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
	WebFont.load({
		google: {
			"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
		},
		active: function() {
			sessionStorage.fonts = true;
		}
	});
</script> -->


<!--end::Page Vendors -->

<?php if(\App::isLocale('en')): ?>
	<link href="<?php echo e(asset('assets/vendors/base/vendors.bundle.css')); ?>" rel="stylesheet" type="text/css" />


	<link href="<?php echo e(asset('assets/demo/default/base/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />

<?php else: ?>
	<link href="<?php echo e(asset('assets/vendors/base/vendors.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />


	<link href="<?php echo e(asset('assets/demo/default/base/style.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />

	<!-- Farsi Fonts -->
	<link href="<?php echo e(asset('css/saleh-farsi-font.css')); ?>" rel="stylesheet" type="text/css" />

	<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

	<!--end::Base Styles -->

<?php endif; ?>

<link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>" /><?php /**PATH C:\xampp\htdocs\hosys\resources\views/layouts/includes/head.blade.php ENDPATH**/ ?>