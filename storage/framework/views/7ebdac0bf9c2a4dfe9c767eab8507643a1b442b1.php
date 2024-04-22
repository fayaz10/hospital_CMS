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
                    <a href="<?php echo e(route('patient.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('reception.pat_Fpage')); ?></span>
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

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('patient.invoice', [$patient->id])); ?>" class="btn btn-secondary">
                            <span> <i class="flaticon-list-3"></i> <span><?php echo e(__('global.invoice')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('patient.edit', [$patient->id])); ?>" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span><?php echo e(__('profile.edit')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('patient.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?>

                                    </span> </span> </a> <div class="m-separator m-separator--dashed d-xl-none">
                    </div>
                </div>
            </div>
        </div>
        <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-lg-9 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#" data-target="#profile" data-toggle="tab" class="nav-link active"><?php echo e(__('reception.pat_info')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#activities" data-toggle="tab" class="nav-link"><?php echo e(__('reception.vis_info')); ?></a>
                    </li>

                    <li class="nav-item">
                        <a href="#" data-target="#prescription" data-toggle="tab" class="nav-link"><?php echo e(__('pharmacist.side_prescription')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#experiment" data-toggle="tab" class="nav-link"><?php echo e(__('lab.lab_exp')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#emergency" data-toggle="tab" class="nav-link"><?php echo e(__('global.emergency')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#din" data-toggle="tab" class="nav-link"><?php echo e(__('finance.sideDiverseIncome')); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title"><?php echo e(__('reception.pat_fullInfo')); ?></h3>
                        </div>
                        <div class="row">
                            <!-- <div class="row"> -->
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.pat_name')); ?></u></label>
                                <p><strong><?php echo e($patient->name); ?></strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.pat_age')); ?></u></label>
                                <p><strong><?php echo e($patient->age); ?></strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.sex')); ?></u></label>
                                <p><strong><?php echo e(__("reception.{$patient->sex}")); ?></strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.pat_record')); ?></u></label>
                                <p><strong><?php echo e($patient->record_no); ?></strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.pat_phone')); ?></u></label>
                                <p><strong><?php echo e($patient->phone_no); ?> </strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('reception.vis_address')); ?></u></label>
                                <p><strong><?php echo e($patient->address); ?> </strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('profile.user_regdate')); ?></u></label>
                                <p><strong><?php echo e($patient->created_at ? $patient->created_at->format('Y-m-d h:m A') : ''); ?></strong>
                                </p>
                            </div>
                            <div class="col-lg-8 m-form__group-sub">
                                <label class="form-control-label"><u><?php echo e(__('profile.user_registrant')); ?></u></label>
                                <p><strong><?php echo e($patient->registrar->name); ?>->
                                        <?php echo e($patient->registrar->email); ?></strong>
                                </p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>

                    <div class="tab-pane" id="activities">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title"><?php echo e(__('reception.patientLastVisits')); ?></h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            <?php $__currentLoopData = $patient->visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('visit.show', [$visit->id])); ?>" class="list-group-item list-group-item-action">
                                <?php echo e($key + 1 . '. ' . $visit->created_at->format('Y-m-d') . ' ' . __('global.at') . ' ' .$visit->created_at->format('g:i A')); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="prescription">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.pre_presInfo')); ?></h3>
                        </div>
                        <?php $__currentLoopData = $patient->prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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
                        <?php $__currentLoopData = $patient->experiments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $experiment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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

                    <div class="tab-pane" id="emergency">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title"><?php echo e(__('global.emrLatestPayments')); ?></h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            <?php $__currentLoopData = $patient->emergencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $emergency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('emergency.show', [$emergency->id])); ?>" class="list-group-item list-group-item-action">
                                <?php echo e($key + 1 . '. ' . __('global.reason')); ?>: <?php echo e($emergency->reason); ?>

                                <br>
                                <?php echo e(optional($emergency->created_at)->format('Y-m-d') . ' ' . __('global.at') . ' ' . optional($emergency->created_at)->format('g:i A')); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="din">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title"><?php echo e(__('finance.sideDiverseIncome')); ?></h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            <?php $__currentLoopData = $patient->din; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $din): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('din.show', [$din->id])); ?>" class="list-group-item list-group-item-action">
                                <?php echo e($key + 1 . '. ' . __('finance.dSubject')); ?>: <?php echo e($din->subject); ?>

                                <br>
                                <?php echo e(optional($din->created_at)->format('Y-m-d') . ' ' . __('global.at') . ' ' . optional($din->created_at)->format('g:i A')); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 order-lg-1 text-center">
                <img src="<?php echo e(file_exists($patient->photo) ? asset($patient->photo) : url('assets/app/media/img/users/user4.jpg')); ?>" class="mx-auto img-fluid img-thumbnail img-circle d-block" alt="avatar">
                <p><?php echo e(app()->isLocale('dr') ? 'عکس مریض': 'Patient Photo'); ?></p>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/receptionist-module/patient/show.blade.php ENDPATH**/ ?>