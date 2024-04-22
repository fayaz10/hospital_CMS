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
    <div class="m-portlet m-portlet--mobile" id="m_portlet_tools_3">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-search"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        <?php echo e(__('global.dailyReports')); ?>

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
            <form action="" id="save-form" class="m-form m-form--label-align-left m-form--state col-12">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group row">

                            <div class="col-lg-8 m-form__group-sub mt-3">
                                <label class="form-control-label"><?php echo e(__('global.approveBy')); ?></label>
                                <select class="form-control m-input multiple" name="approver_id[]">
                                    <?php $__currentLoopData = \App\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e($user->id == auth()->id() ? 'selected' : null); ?>>
                                        <?php echo e(app()->isLocale('en') ? $user->name : $user->name_dr); ?> (<?php echo e($user->email); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="col-lg-4 m-form__group-sub mt-3">
                                <label class="form-control-label"><?php echo e(__('admin.adm_state')); ?></label>
                                <select class="form-control m-input multiple" name="is_approved[]">
                                    <option value="1"><?php echo e(__('global.received')); ?></option>
                                    <option value="0"><?php echo e(__('global.pending')); ?></option>
                                    
                                </select>
                            </div>

                            <div class="col-lg-6 m-form__group-sub mt-3">
                                <label class="form-control-label">
                                    <?php echo e(__('reception.pat_regdate')); ?>

                                    <?php echo e(__('reception.from')); ?>

                                </label>
                                <div class="input-group m-input-group">
                                    <input type="date" value="<?php echo e(date('Y-m-d')); ?>" name="from_date" class="form-control m-input"
                                        placeholder="">
                                    <div class="input-group-append">
                                        <input type="time" name="from_time" class="form-control m-input"
                                            value="00:00:00">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 m-form__group-sub mt-3">
                                <label class="form-control-label">
                                    <?php echo e(__('reception.pat_regdate')); ?>

                                    <?php echo e(__('reception.till')); ?>

                                </label>
                                <div class="input-group m-input-group">
                                    <input type="date" name="till_date" class="form-control m-input"
                                        value="<?php echo e(date('Y-m-d')); ?>">
                                    <div class="input-group-append">
                                        <input type="time" name="till_time" class="form-control m-input"
                                            value="23:59:59">
                                    </div>
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
            <div class="m-widget29">
                <div class="m-widget_content">
                    <h3 class="m-widget_content-title"><?php echo e(__('global.quickResult')); ?></h3>
                    <div class="m-widget_content-items">
                        <div class="m-widget_content-item">
                            <span><?php echo e(__('global.totalRecord')); ?></span>
                            <span class="m--font-accent" id="totalRecord">0</span>
                        </div>
                        <div class="m-widget_content-item">
                            <span><?php echo e(__('global.totalPaidAmount')); ?></span>
                            <span class="m--font-brand" id="totalPayment">0</span>
                        </div>
                        <div class="m-widget_content-item">
                            <span><?php echo e(__('global.refund_notes')); ?></span>
                            <i class="fa fa-arrow-circle-up text-danger"></i> <span style="display: inline; font-size: 1.5rem;
                            font-weight: 600;" id="minus">0</span>
                            &nbsp;&nbsp;&nbsp;
                            <i class="fa fa-arrow-circle-down text-success"></i> <span id="plus" style="display: inline">0</span>
                        </div>
                        <div class="m-widget_content-item">
                            <span><?php echo e(__('global.total_checkout')); ?></span>
                            <span id="checkout">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <table class="table m-table m-table--head-separator-primary" id="bootstrap-table" data-show-export="true"
                data-show-print="true" data-pagination="true" data-show-columns="true">
                <thead>
                    <tr>
                        <!-- <th data-field="id" data-sortable="true">#</th> -->
                        <th data-field="no" data-sortable="true">#</th>
                        <th data-field="source" data-sortable="true"><?php echo e(__('finance.incSection')); ?></th>
                        <th data-field="payment_date" data-sortable="true"><?php echo e(__('finance.paymentDate')); ?></th>
                        <th data-field="recipient" data-sortable="true"><?php echo e(__('finance.paymentRecipient')); ?></th>
                        <th data-field="amount" data-sortable="true"><?php echo e(__('finance.amount')); ?></th>
                        <th data-field="taxes" data-sortable="true"><?php echo e(__('reception.pay_tax')); ?></th>
                        <th data-field="totalAmount" data-sortable="true"><?php echo e(__('reception.amountOfPayament')); ?></th>
                        <th data-field="registrar" data-sortable="true"><?php echo e(__('pharmacist.med_register')); ?></th>
                        <th data-field="status" data-sortable="true"><?php echo e(__('admin.adm_state')); ?></th>
                        <th data-field="approvedBy" data-sortable="true"><?php echo e(__('global.approveBy')); ?></th>
                        <th data-field="created_at" data-sortable="true"><?php echo e(__('reception.pat_regdate')); ?></th>
                        <th data-field="operation" data-printIgnore="true" ><?php echo e(__('global.view')); ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

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

        $('.multiple').select2({
            multiple: true,
            tags: "true"
        });

        var portlet = new mPortlet("m_portlet_tools_3");
        new mPortlet("resultPortlet");

        var table = $('#bootstrap-table').bootstrapTable({
            exportTypes: ['excel', 'csv', 'txt'],
            locale: '<?php echo e(app()->isLocale("en") ? "en-US" : "fa-IR"); ?>'
        });

        $('.fixed-table-loading').remove();

        $('#save-form').on('submit', function (e) {
            e.preventDefault(); //prevent form from submitting
            var data = $("#save-form").serializeArray();

            mApp.block("#save-form", {
                overlayColor: "#000000",
                type: "loader",
                message: "<?php echo e(__('global.loading')); ?> ..."
            });
            //submit the form
            $.ajax({
                url: '<?php echo e(route("reports.index")); ?>',
                type: "GET",
                data: data,
                dataType: "json",
                success: function (response) {
                    data = response.data
                    minus = response.notes.minus || 0
                    plus = response.notes.plus || 0
                    output = [];
                    totalPayment = 0;
                    data.forEach(function (arrayItem, i) {
                        output.push({
                            "no": ++i,
                            "source": arrayItem.name,
                            "payment_date": arrayItem.payment_date,
                            "recipient": arrayItem.recipient,
                            "amount": arrayItem.amount,
                            "taxes": arrayItem.taxes,
                            "totalAmount": arrayItem.totalAmount,
                            "registrar": arrayItem.registrar.name,
                            "status": arrayItem.is_approved == 1 ? "<?php echo e(__('global.received')); ?>" : "<?php echo e(__('global.pending')); ?>" ,
                            "approvedBy": arrayItem.approved_by ? arrayItem.approved_by.name : null,
                            "created_at": arrayItem.created_at,
                            "operation": "<a href='" + arrayItem.url + "'<i class='flaticon-eye'></i></a>"
                        });
                        
                        totalPayment += arrayItem.totalAmount;
                    });

                    //remove the loader
                    mApp.unblock('#save-form');

                    // minimize the search portlet
                    portlet.collapse();

                    table.bootstrapTable('load', output);
                    
                    // count the quick result part
                    $("#totalRecord").text(data.length);
                    $("#totalPayment").text(totalPayment);
                    $("#minus").text(parseInt(minus));
                    $("#plus").text(parseInt(plus));
                    $("#checkout").text(parseInt(totalPayment) + parseInt(plus) - parseInt(minus));
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(
                        'Something is going wrong.\nPlease call to iSys Software Solutions.'
                    );
                }
            });
        });
    });

    $('#save-button').click(function () {
        $('#save-form').submit();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/receptionist-module/reports/daily.blade.php ENDPATH**/ ?>