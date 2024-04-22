<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('lab-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('lab.lab_mod')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="<?php echo e(route('visit.index')); ?>" class="m-nav__link">
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
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
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
                            <?php echo e(__('lab.lab_expEdit')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="<?php echo e(route('experiment.index')); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span><?php echo e(__('global.gol_back')); ?></span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
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
            <form action="<?php echo e(route('test-completion.update', [$test_completion->id])); ?>" onsubmit="var desc = $('#description'); desc.val('\'\n' +desc.val())" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <?php echo method_field('put'); ?>
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="form-group m-form__group-sub">
                                <label for="experimentor" class="form-control-label"><?php echo e(__('lab.lab_test')); ?></label>
                                <strong><p><?php echo e(optional($test_completion->test)->name); ?></p></strong>
                            </div>
                            <div class="form-group m-form__group-sub">
                                <label for="experimentor" class="form-control-label"><?php echo e(__('lab.lab_expExperimentor')); ?></label>
                                <input type="text" required value="<?php echo e($test_completion->experimentor ?? auth()->user()->name); ?>" class="form-control" name="experimentor" id="experimentor">
                            </div>
        
                            <div class="form-group m-form__group row">
                                <div class="col-md-12 m-form__group-sub">
                                    <label for="results" class="form-control-label"><?php echo e(__('pharmacist.r_range')); ?></label>
                                    
                                    <textarea required class="form-control summernote" name="results" rows="25" id="results"></textarea>
                                    
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
<script type="text/javascript" src="<?php echo e(asset('js/messages_' . app()->getLocale() . '.js')); ?>"></script>

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });

    $(document).ready(function () {
        
        var markupStr = `
                <?php if($test_completion->results): ?>
                    <?php echo $test_completion->results; ?>

                <?php else: ?>
                    <?php $__empty_1 = true; $__currentLoopData = optional($test_completion->test)->subTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subTest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <strong><?php echo e(++$key); ?>. <?php echo e($subTest->name); ?></strong><br>
                        <?php echo nl2br($subTest->range); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        --
                    <?php endif; ?>
                <?php endif; ?>
        `;
        $(".summernote").summernote({
            height:400,
            toolbar: [
                ['style', ['bold']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ],
            'code': markupStr
        })
        $(".summernote").summernote("code", markupStr)
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/lab-module/experiment/test-complition-edit.blade.php ENDPATH**/ ?>