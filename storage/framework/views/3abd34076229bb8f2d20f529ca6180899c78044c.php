<?php $__env->startSection('styles'); ?>
<!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('receptionist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader">
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
                    <a href=" <?php echo e(route('visit.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('reception.vis_pat_visit')); ?></span>
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
    
    <?php
        $printLogs = \App\PrintLog::with(['user:id,name_dr'])
                                    ->where('printable_id', $visit->id)
                                    ->where('printable_type', \App\Models\Receptionist\Visit::class)
                                    ->get();
    ?>

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">

                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('visit.search')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>

                        <?php
                            $userPrintedLogCounter = $printLogs->where('printed_user', auth()->id());
                        ?>

                        <?php if(auth()->user()->can('print_again') || $userPrintedLogCounter->count() <= 1): ?>
                            <a href="<?php echo e(route('visit.print', [$visit->id])); ?>" class="btn btn-secondary">
                                <span> <i class="la la-print"></i> <span><?php echo e(__('global.print')); ?></span> </span> </a>
                        <?php endif; ?>

                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('visit.edit', [$visit->id])); ?>" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span><?php echo e(__('profile.edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('visit.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#activities" data-toggle="tab" class="nav-link active"><?php echo e(__('reception.vis_info')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link"><?php echo e(__('reception.pat_info')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#modules" data-toggle="tab" class="nav-link"><?php echo e(__('reception.docy_info')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#prescription" data-toggle="tab" class="nav-link"><?php echo e(__('pharmacist.side_prescription')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#experiment" data-toggle="tab" class="nav-link"><?php echo e(__('lab.lab_exp')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#print-log" data-toggle="tab" class="nav-link text-danger"><?php echo e(__('global.printLog')); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="activities">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('reception.vis_fullInfo')); ?></h3>
                            </div>
                            <div class="row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.vis_cashier')); ?></u></label>
                                        <p><strong><?php echo e($visit->cashier->email); ?>

                                                "<?php echo e($visit->cashier->name_dr); ?>"</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('profile.user_regdate')); ?></u></label>
                                        <?php
                                        if(app()->getLocale() == 'dr'){
                                        setlocale(LC_TIME, 'fa_IR');
                                        Carbon\Carbon::setLocale('fa');
                                        }
                                        ?>
                                        <p><strong>
                                                <?php echo e($visit->created_at ? $visit->created_at->format('Y-m-d h:m A') : ''); ?>

                                                <br>
                                                "<?php echo e($visit->created_at ? $visit->created_at->diffForHumans() : ''); ?>"
                                            </strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.pay_cashier')); ?></u></label>
                                        <p><strong><?php echo e($visit->profit->recipient); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.docy_Fvalue')); ?></u></label>
                                        <p><strong><?php echo e($visit->profit->amount); ?>

                                                <?php echo e($visit->profit->currency->label_dr); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.pay_tax')); ?></u></label>
                                        <p><strong><?php echo e($visit->profit->taxes); ?>

                                                <?php echo e($visit->profit->currency->label_dr); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.pay_amount')); ?></u></label>
                                        <p><strong><?php echo e($visit->profit->totalAmount); ?>

                                                <?php echo e($visit->profit->currency->label_dr); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.pay_discount')); ?></u></label>
                                        <p><strong><?php echo e($visit->discount ? $visit->discount ."%" : __('global.gol_no')); ?></strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.pay_cardNum')); ?></u></label>
                                        <p><strong><?php echo e($visit->membership_id); ?></strong></p>
                                    </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('reception.pat_fullInfo')); ?></h3>
                            </div>
                            <div class="row">
                                <!-- <div class="row"> -->
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.pat_name')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->name); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.pat_age')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->age); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.sex')); ?></u></label>
                                    <p><strong><?php echo e(__("reception.{$visit->patient->sex}")); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.pat_record')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->record_no); ?></strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.pat_phone')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->phone_no); ?> </strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('reception.vis_address')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->address); ?> </strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('profile.user_regdate')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->created_at ? $visit->patient->created_at->format('Y-m-d h:m A') : ''); ?></strong>
                                    </p>
                                </div>
                                <div class="col-lg-8 m-form__group-sub">
                                    <label class="form-control-label"><u><?php echo e(__('profile.user_registrant')); ?></u></label>
                                    <p><strong><?php echo e($visit->patient->registrar->name); ?>->
                                            <?php echo e($visit->patient->registrar->email); ?></strong>
                                    </p>
                                </div>
                            </div>
                            <!--/row-->
                        </div>

                        <div class="tab-pane" id="modules">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('reception.docy_Info')); ?></h3>
                            </div>
                            <div class="row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('reception.docy_name')); ?> </u></label>
                                        <p><strong><?php echo e($visit->doctor->first_name); ?>

                                                "<?php echo e($visit->doctor->last_name); ?>"</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('reception.docy_email')); ?>

                                            </u></label>
                                        <p><strong><?php echo e($visit->doctor->email); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('reception.docy_specialze')); ?>

                                            </u></label>
                                        <p><strong><?php echo e($visit->doctor->specialist); ?> </strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u><?php echo e(__('reception.docy_fees')); ?></u></label>
                                        <p><strong><?php echo e($visit->doctor->visit_fee); ?>

                                                <?php echo e($visit->doctor->currency->label_dr); ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('profile.user_registrant')); ?>

                                            </u></label>
                                        <p><strong><?php echo e($visit->doctor->registrar->name); ?>->
                                                <?php echo e($visit->doctor->registrar->email); ?></strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> <?php echo e(__('profile.user_regdate')); ?></u></label>
                                        <p><strong><?php echo e($visit->doctor->created_at); ?></strong>
                                        </p>
                                    </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="prescription">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.pre_presInfo')); ?></h3>
                            </div>
                            <?php $__currentLoopData = $visit->patient->prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="row form-group m-form__group ">
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.pre_issueDate')); ?> </label>
                                    <p><strong><?php echo e($prescription->date); ?></strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_register')); ?></label>
                                    <p><strong><?php echo e(app()->getLocale() == 'en' ? $prescription->registrar->name : $prescription->registrar->name_dr); ?></strong>
                                    </p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> <?php echo e(__('global.operation')); ?></label>
                                    <p><strong>
                                            <?php echo e($prescription->profit->totalAmount); ?>

                                            <?php echo e(app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr); ?>

                                        </strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.pre_totalPayment')); ?></label>
                                    <p>
                                        <a href="<?php echo e(route('prescription.show', [$prescription->id])); ?>"><strong><?php echo e(__('global.view')); ?></strong></a>
                                    </p>
                                </div>
                            </div>

                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> <?php echo e(__('pharmacist.med_number')); ?></th>
                                        <th> <?php echo e(__('pharmacist.med_name')); ?></th>
                                        <th> <?php echo e(__('pharmacist.med_type')); ?></th>
                                        <th> <?php echo e(__('pharmacist.pre_medicine_quantity')); ?></th>
                                        <th> <?php echo e(__('pharmacist.med_price')); ?></th>
                                        <th> <?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                                        <th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $prescription->medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($medicine->name); ?> (<?php echo e($medicine->milligram); ?>)</td>
                                        <td><?php echo e(app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr); ?>

                                        </td>
                                        <td>
                                            <?php echo e($medicine->pivot->quantity); ?>

                                            <?php echo e(app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr); ?>

                                        </td>
                                        <td>
                                            <?php echo e($medicine->pivot->unit_price); ?>

                                            <?php echo e(app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr); ?>

                                        </td>
                                        <td>
                                            <?php echo e(($medicine->pivot->quantity * $medicine->pivot->unit_price)); ?>

                                            <?php echo e(app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="tab-pane" id="experiment">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('lab.lab_expInf')); ?></h3>
                            </div>
                            <?php $__currentLoopData = $visit->patient->experiments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $experiment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="row form-group m-form__group ">
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"><?php echo e(__('reception.pat_record')); ?> </label>
                                    <p><strong><?php echo e($experiment->record_no); ?></strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"><?php echo e(__('pharmacist.med_register')); ?></label>
                                    <p><strong><?php echo e(app()->getLocale() == 'en' ? $experiment->registrar->name : $experiment->registrar->name_dr); ?></strong>
                                    </p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.pre_totalPayment')); ?></label>
                                    <p><strong>
                                            <?php echo e($experiment->profit->totalAmount); ?>

                                            <?php echo e(app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr); ?>

                                        </strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> <?php echo e(__('pharmacist.pre_totalPayment')); ?></label>
                                    <p>
                                        <a href="<?php echo e(route('experiment.show', [$experiment->id])); ?>"><strong><?php echo e(__('global.view')); ?></strong></a>
                                    </p>
                                </div>
                            </div>

                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> <?php echo e(__('pharmacist.med_number')); ?></th>
                                        <th> <?php echo e(__('lab.lab_experiment')); ?></th>
                                        <th> <?php echo e(__('lab.lab_expExperimentor')); ?></th>
                                        <th> <?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $experiment->tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($test->name); ?></td>
                                        <td><?php echo e($test->pivot->experimentor); ?></td>
                                        <td>
                                            <?php echo e($test->pivot->price); ?>

                                            <?php echo e(app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="tab-pane" id="print-log">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo e(__('global.printLog')); ?></h3>
                            </div>
                            
                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> <?php echo e(__('pharmacist.med_number')); ?></th>
                                        <th> <?php echo e(__('admin.usr_name')); ?></th>
                                        <th> <?php echo e(__('global.date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $printLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e(optional($log->user)->name_dr); ?></td>
                                        <td><?php echo e($log->created_at); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 order-lg-1 text-center">
                    <img src="<?php echo e(file_exists($visit->patient->photo) ? asset($visit->patient->photo) : url('assets/app/media/img/users/user4.jpg')); ?>" class="mx-auto img-fluid img-circle d-block" alt="avatar">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugins'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/receptionist-module/visit/show.blade.php ENDPATH**/ ?>