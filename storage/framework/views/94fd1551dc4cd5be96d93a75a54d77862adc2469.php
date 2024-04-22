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
                    <a href="<?php echo e(route('visit.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('reception.vis_pat_visit')); ?></span>
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
                            <?php echo e(__('reception.vis_Nadd')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="<?php echo e(route('visit.index')); ?>"
                        class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span><?php echo e(__('global.gol_back')); ?></span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button"
                            class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
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
            <form action="<?php echo e(route('visit.store')); ?>" id="save-form" enctype="multipart/form-data" class="m-form "
                method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="m-form__section">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-12">
                                    <label class="form-control-label"><?php echo e(__('reception.vis_alert')); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- <label class="m-radio m-radio--single m-radio--state"> -->
                                                <input type="checkbox" onclick="changeStatus(this)"
                                                    name="patient_exists">
                                                <!-- </label> -->
                                                &nbsp;&nbsp;&nbsp;
                                                <span><?php echo e(__('reception.vis_yes')); ?></span>
                                            </span>
                                        </div>
                                        <select class="form-control m-input" disabled name="patient_id" id="patient">

                                        </select>
                                        <!-- <input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>"> -->
                                    </div>
                                    <!-- <span class="m-form__help">درصورت انتخاب ایجاد یوزر جدید، پاسورد یوزر، user@iSys میباشد.</span> -->
                                </div>
                            </div>

                            <div class="m-form__heading">
                                <h2 class="m-form__heading-title"><?php echo e(__('reception.vis_new')); ?></h2>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"><span
                                            class="text-danger">*</span><?php echo e(__('reception.pat_Fullname')); ?></label>
                                    <input type="text" value="<?php echo e(old('name')); ?>" name="name" required
                                        class="form-control newPatient m-input" placeholder="">
                                </div>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">
                                        <span class="text-danger">* </span><?php echo e(__('reception.sex')); ?>

                                    </label>
                                    <select class="form-control newPatient m-input" name="sex">
                                        <option value="m">
                                            <?php echo e(__("reception.m")); ?>

                                        </option>
                                        <option value="f">
                                            <?php echo e(__("reception.f")); ?>

                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"> <span
                                            class="text-danger">*</span><?php echo e(__('reception.pat_age')); ?></label>
                                    <input type="number" value="<?php echo e(old('age')); ?>" name="age" required
                                        class="form-control newPatient m-input" placeholder="">
                                </div>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.pat_phone')); ?></label>
                                    <input type="text" value="<?php echo e(old('phone_no')); ?>" name="phone_no"
                                        class="form-control newPatient m-input" placeholder="">
                                </div>

                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.vis_address')); ?></label>
                                    <input type="text" value="<?php echo e(old('address')); ?>" name="address"
                                        class="form-control newPatient m-input" placeholder="">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"><?php echo e(__('profile.prfilePic')); ?></label>
                                    <div class="custom-file">
                                        <input type="file" name="img_path" class="custom-file-input newPatient">
                                        <label class="custom-file-label"
                                            for="customFile"><?php echo e(__('profile.user_chosePhoto')); ?></label>
                                    </div>
                                </div>
                                <?php if (\Entrust::can('rec_vis_discount')) : ?>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.pay_discount')); ?></label>
                                    <select class="form-control m-input" name="discount" id="discount">
                                        <option value="">
                                        </option>
                                        <option value="10">
                                            10%
                                        </option>
                                        <option value="15">
                                            15%
                                        </option>
                                        <option value="20">
                                            20%
                                        </option>
                                        <option value="25">
                                            25%
                                        </option>
                                        <option value="30">
                                            30%
                                        </option>
                                        <option value="35">
                                            35%
                                        </option>
                                        <option value="40">
                                            40%
                                        </option>
                                        <option value="50">
                                            50%
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label"><?php echo e(__('reception.pay_cardNum')); ?></label>
                                    <input type="number" value="<?php echo e(old('member_id')); ?>" name="member_id"
                                        class="form-control m-input newPatient" placeholder="">
                                </div>
                                <?php endif; // Entrust::can ?>
                            </div>

                        </div>

                        <div class="m-form__heading">
                            <h2 class="m-form__heading-title"><?php echo e(__('reception.vis_newInfo')); ?></h2>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3 m-form__group-sub">
                                <label class="form-control-label"> <span class="text-danger">*
                                    </span><?php echo e(__('pharmacist.pre_docName')); ?></label>
                                <select class="form-control m-input" name="doctor_id" onchange="selectDoctor(this)"
                                    id="doctor">
                                    <option value=""></option>
                                    <?php $__currentLoopData = \App\Models\Receptionist\Doctor::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($doctor->id); ?>" fee="<?php echo e($doctor->visit_fee); ?>" readonly
                                        currency="<?php echo e($doctor->currency_id); ?>">
                                        <?php echo e($doctor->name); ?> (<?php echo e($doctor->specialist); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-3 m-form__group-sub">
                                <label class="form-control-label"><span class="text-danger"><span class="text-danger">*
                                        </span> </span><?php echo e(__('reception.docy_Fvalue')); ?></label>
                                <input type="number" name="amount" readonly required class="form-control m-input"
                                    value="<?php echo e(old('amount')); ?>" placeholder="">
                            </div>
                            <div class="col-lg-2 m-form__group-sub">
                                <label class="form-control-label">
                                    <span class="text-danger">* </span><?php echo e(__('reception.docy_currency')); ?>

                                </label>
                                <select class="form-control m-input" readonly name="currency_id">
                                    <?php $__currentLoopData = \App\Models\FinanceModule\Currency::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" disabled>
                                        <?php echo e($type->label_dr); ?> (<?php echo e($type->symbol); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-lg-2 m-form__group-sub">
                                <label class="form-control-label"><span class="text-danger">*
                                    </span><?php echo e(__('reception.pay_date')); ?></label>
                                <input type="date" name="payment_date" required class="form-control m-input"
                                    value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" placeholder="">
                            </div>
                            <div class="col-lg-2 m-form__group-sub">
                                <label class="form-control-label"><span class="text-danger">*
                                    </span><?php echo e(__('reception.pay_cashier')); ?></label>
                                <input type="text" name="recipient" required class="form-control m-input"
                                    value="<?php echo e(old('recipient', auth()->user()->name_dr)); ?>" placeholder="">
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
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#discount').select2({
            placeholder: '<?php echo e(__("reception.rec_choose")); ?>',
            tag: true
        });
        $('#doctor').select2({
            placeholder: '<?php echo e(__("reception.rec_choose")); ?>',
            tag: true
        });

        $('#patient').select2({
            placeholder: '<?php echo e(__("reception.rec_search")); ?>',
            minimumInputLength: 5,
            ajax: {
                url: "<?php echo e(route('patient.filter')); ?>",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function (term) {
                    return term;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.record_no + ' (' + item.name + ')',
                                slug: item.record_no,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    });

    function changeStatus(param) {
        var status = $(param).is(':checked');
        $('#patient').prop("disabled", !status);
        $('.newPatient').prop("disabled", status);
    }

    function selectDoctor(param) {
        $('input[name=amount]').val($('option:selected', param).attr('fee'));
        $('select[name=currency_id]').val($('option:selected', param).attr('currency'));
        $('select[name=currency_id] option:selected').prop('disabled', false);
    }

    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');
        form.validate();

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });

        if (form.valid())
            form.submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\hosys\resources\views/receptionist-module/visit/create.blade.php ENDPATH**/ ?>