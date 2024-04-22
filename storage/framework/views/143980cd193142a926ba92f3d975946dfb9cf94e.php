<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('finance-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('finance.finance-module')); ?></h3>
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
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('income.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <hr>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                        <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="m-form__heading mt-3">
                            <h2 class="m-form__heading-title"><?php echo e(__('finance.eInfoNewDiverIncome')); ?></h2>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label"> 
                                <?php echo e(__('finance.dCategory')); ?></label>
                                    <p><strong><?php echo e(app()->isLocale('en') ? $diverse_expense->category->label_en : $diverse_expense->category->label_dr); ?></strong>
                                    </p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                <?php echo e(__('finance.dSubject')); ?></label>
                                    <p><strong><?php echo e($diverse_expense->reason); ?></strong></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                    <?php echo e(__('finance.dType')); ?>

                                </label>
                                <p><strong><?php echo e(__("finance.{$diverse_expense->type}")); ?></strong></p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                <?php echo e(__('reception.pay_date')); ?></label>
                                <p><strong><?php echo e($diverse_expense->spend->payment_date); ?></strong></p>
                            </div>


                        </div>
                        <div class="form-group m-form__group row">

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label"><?php echo e(__('reception.docy_Fvalue')); ?></label>
                                <p><strong><?php echo e($diverse_expense->spend->amount); ?> <?php echo e(app()->isLocale('en') ? $diverse_expense->spend->currency->label_en : $diverse_expense->spend->currency->label_dr); ?></strong></p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                    <?php echo e(__('reception.docy_currency')); ?>

                                </label>
                                <p><strong><?php echo e(app()->isLocale('en') ? $diverse_expense->spend->currency->label_en : $diverse_expense->spend->currency->label_dr); ?></strong></p>
                            </div>

                        </div>

                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label">
                                <?php echo e(__('reception.pay_cashier')); ?></label>
                                <p><strong><?php echo e($diverse_expense->spend->remitter); ?></strong></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label"><?php echo e(__("finance.description")); ?></label>
                                <textarea name="description" cols="30" rows="10"
                                    class="form-control m-input"><?php echo e($diverse_expense->description); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/messages_' . app()->getLocale() . '.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script type="text/javascript">
    $('#save-button').click(function () {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/finance-module/diverse-expense/show.blade.php ENDPATH**/ ?>