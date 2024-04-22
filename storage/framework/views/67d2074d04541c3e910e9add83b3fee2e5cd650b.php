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
    <div class="m-portlet m-portlet--mobile" id="m_portlet_tools_3">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-graph"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        <?php echo e(__('global.incomeBalance')); ?>

                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-angle-down"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-expand"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-close"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <form action="" method="GET" id="save-form" class="m-form m-form--label-align-left m-form--state col-12">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group row">

                            <div class="col-lg-1 m-form__group-sub">
                                <div class="m-form__group form-group">
                                    <label for="">&nbsp;</label>
                                    <div class="m-checkbox-list" >
                                        <label class="m-checkbox">
                                            <input type="checkbox" onclick="$('.multiple option').attr('selected', $(this).is(':checked')).parent().trigger('change')"> 
                                            <?php echo e(__('global.all')); ?>

                                            <span></span>
                                        </label>
                                    </div>
                                </div>                       
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><?php echo e(__('reception.vis_doctors')); ?></label>
                                <select class="form-control m-input multiple" name="doctors[]">
                                    <option></option>
                                    <?php $__currentLoopData = \App\Models\Receptionist\Doctor::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($doctor->id); ?>">
                                        <?php echo e($doctor->name); ?> (<?php echo e($doctor->specialist); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-1 m-form__group-sub">
                                <div class="m-form__group form-group">
                                    <label for=""><?php echo e(__('global.onlyApproved')); ?></label>
                                    <div class="m-checkbox-list" >
                                        <label class="m-checkbox">
                                            <input name="is_approved" checked type="checkbox">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>                       
                            </div>
                            
                            <div class="col-lg-3 m-form__group-sub">
                                <label class="form-control-label">
                                    <?php echo e(__('reception.pat_regdate')); ?>

                                    <?php echo e(__('reception.from')); ?>

                                </label>
                                <div class="input-group m-input-group">
                                    <input type="date" value="" name="from_date" class="form-control m-input"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-3 m-form__group-sub">
                                <label class="form-control-label">
                                    <?php echo e(__('reception.pat_regdate')); ?>

                                    <?php echo e(__('reception.till')); ?>

                                </label>
                                <div class="input-group m-input-group">
                                    <input type="date" value="" name="till_date" class="form-control m-input"
                                        placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="m-portlet__foot">
            <button type="submit" class="btn btn-primary" id="save-button">
                <i class="flaticon-search"></i>
                <?php echo e(__('global.search2')); ?>

            </button>
        </div>
    </div>
    
    <?php if($printingResult): ?>
        
        <div class="m-portlet m-portlet--mobile" id="resultPortlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-file"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            <?php echo e(__('reception.searchResult')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-expand"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-close"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body" id="">
                <table class="table m-table m-table--head-separator-primary" id="bootstrap-table" data-show-export="true"
                    data-show-print="true" data-pagination="true" data-show-columns="true">
                    <thead>
                        <tr>
                            <th data-sortable="true"><?php echo e(__('reception.vis_doctors')); ?></th>
                            <th data-sortable="true"><?php echo e(__('reception.pat_regdate')); ?> <?php echo e(__('reception.from')); ?></th>
                            <th data-sortable="true"><?php echo e(__('reception.pat_regdate')); ?> <?php echo e(__('reception.till')); ?></th>
                            <th data-sortable="true" ><?php echo e(__('finance.incSection')); ?></th>
                            <th data-sortable="true"><?php echo e(__('reception.pay_tax')); ?></th>
                            <th data-sortable="true"><?php echo e(__('reception.amountOfPayament')); ?></th>
                            <th data-sortable="true"><?php echo e(__('global.allAmount')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $printingResult; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc => $incomeList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $incomeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <?php if(array_key_first($incomeList->toArray()) == $source): ?>
                                        <td><?php echo e($doc); ?></td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                    
                                    <td><?php echo e($values['to'] ?? null); ?></td>
                                    <td><?php echo e($values['from'] ?? null); ?></td>
                                    <td><?php echo e($source); ?></td>
                                    <td><?php echo e($values['tax'] ?? null); ?></td>
                                    <td><?php echo e($values['amount'] ?? null); ?></td>
                                    <?php if(array_key_first($incomeList->toArray()) == $source): ?>
                                        <td><?php echo e($incomeList->sum('amount')); ?></td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/bootstrap-table/bootstrap-table.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-table/bootstrap-table-print.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-table/tableExport.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-table/bootstrap-table-export.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-table/locale/bootstrap-table-fa-IR.min.js')); ?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {

        // var portlet = new mPortlet("m_portlet_tools_3");
        // new mPortlet("resultPortlet");

        $('.multiple').select2({
            multiple: true,
            tags: "true"
        });

        var table = $('#bootstrap-table').bootstrapTable({
            exportTypes: ['excel'],
            locale: '<?php echo e(app()->isLocale("en") ? "en-US" : "fa-IR"); ?>'
        });

        // $('.fixed-table-loading').remove();

        // $('#save-form').on('submit', function (e) {
        //     e.preventDefault(); //prevent form from submitting
        //     var data = $("#save-form").serializeArray();

        //     mApp.block("#save-form", {
        //         overlayColor: "#000000",
        //         type: "loader",
        //         message: "<?php echo e(__('global.loading')); ?> ..."
        //     });
        //     //submit the form
        //     $.ajax({
        //         url: '<?php echo e(route("doctor.balance")); ?>',
        //         type: "GET",
        //         data: data,
        //         dataType: "json",
        //         success: function (data) {
        //             console.log(data);
        //             output = [];
        //             Object.keys(data).forEach(function(key) {
        //                 // console.table('Key : ' + key + ', Value : ' + data[key])
        //                 output.push({
        //                     "doctorName" : key,
        //                     "dateFrome" : arrayItem.patient.name,
        //                     "dateTill" : arrayItem.patient.phone_no,
        //                     "income" : arrayItem.patient.age,
        //                     "amount" : arrayItem.doctor.name,
        //                     "totalAmount" : arrayItem.doctor.visit_fee,
        //                 });
        //             })
        //             data.forEach(function (arrayItem) {
        //                 output.push({
        //                     "doctorName" : arrayItem.patient.record_no,
        //                     "dateFrome" : arrayItem.patient.name,
        //                     "dateTill" : arrayItem.patient.phone_no,
        //                     "income" : arrayItem.patient.age,
        //                     "amount" : arrayItem.doctor.name,
        //                     "totalAmount" : arrayItem.doctor.visit_fee,
        //                 });
        //             });

        //             //remove the loader
        //             mApp.unblock('#save-form');

        //             // minimize the search portlet
        //             portlet.collapse();

        //             table.bootstrapTable('load', output);
        //         },
        //         error: function (xhr, ajaxOptions, thrownError) {
        //             alert(
        //                 'Something is going wrong.\nPlease call to iSys Software Solutions.'
        //                 );
        //         }
        //     });
        // });
    });

    $('#save-button').click(function () {
        $('#save-form').submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/receptionist-module/doctor/balance.blade.php ENDPATH**/ ?>