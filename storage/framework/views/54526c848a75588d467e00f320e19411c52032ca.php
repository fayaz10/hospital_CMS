<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('pharmacist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('pharmacist.med_module')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('global.gol_fpage')); ?></span>
                    </a>
                </li>
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
                            <?php echo e(__('pharmacist.pre_addNewPres')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span><?php echo e(__('global.gol_back')); ?></span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span><?php echo e(__('global.gol_save2')); ?></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="<?php echo e(route('prescription.store')); ?>" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 ">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.pre_newPresInfo')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> <?php echo e(__('pharmacist.pre_patientRecord')); ?></label>
                                        <select class="form-control m-input" name="patient_id" id="patient">
                                        </select>
                                    </div>

                                    <div class="col-lg-8 m-form__group-sub">
                                        <label class="form-control-label"><?php echo e(__('pharmacist.pre_docName')); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- <label class="m-radio m-radio--single m-radio--state"> -->
                                                    <input type="checkbox" onclick="changeStatus(this)" checked name="same_doctor">
                                                    <!-- </label> -->
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span><?php echo e(__('pharmacist.pre_selectDifferentDoc')); ?></span>
                                                </span>
                                            </div>
                                            <select class="form-control m-input" name="doctor_id" disabled id="doctor">
                                                <option value=""></option>
                                                <?php $__currentLoopData = \App\Models\Receptionist\Doctor::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($doctor->id); ?>" fee="<?php echo e($doctor->visit_fee); ?>" currency="<?php echo e($doctor->currency_id); ?>">
                                                    <?php echo e($doctor->name); ?> (<?php echo e($doctor->specialist); ?>)
                                                </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> <?php echo e(__('pharmacist.pre_issueDate')); ?></label>
                                        <input type="date" required value="<?php echo e(old('date', date('Y-m-d'))); ?>" name="date" required class="form-control m-input" placeholder="">
                                    </div>

                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> <?php echo e(__('global.paymentType')); ?></label>
                                        <select class="form-control m-input" id="payment_type" name="type">
                                            <option value="now"><?php echo e(__('global.now')); ?></option>
                                            <option value="later"><?php echo e(__('global.payLater')); ?></option>
                                        </select>
                                    </div>

                                    <div class="col-lg-5 m-form__group-sub">
                                        <label class="form-control-label"><?php echo e(__('pharmacist.pre_diagnosis')); ?></label>
                                        <textarea name="diagnosis" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.pre_prescriptedMedicines')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th><?php echo e(__('pharmacist.med_name')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_quantity')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_price')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                                                <th>&nbsp;</th>
                                                <th>
                                                    <button class="btn btn-primary" onclick="addNew(event)">
                                                        <i class="flaticon-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td><select required style="min-width:300px" class="ownerInput" onchange="pasteInfo(this, true);" name="items[0][medicine_id]"></select></td>
                                                <td><input type="number" id="quantity" onchange="calculateBU(this)" required class="form-control" name="items[0][quantity]"></td>
                                                <td><input type="number" tabindex="-1" readonly class="form-control" id="unit-price"></td>
                                                <td><span class="form-control total" tabindex="-1" id="total-price">&nbsp;&nbsp;</span></td>

                                                <td>
                                                    <button class="btn btn-info" tabindex="-1" onclick="event.preventDefault();pasteInfo(this)">
                                                        <i class="flaticon-questions-circular-button"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" tabindex="-1" onclick="remove(this, event)">
                                                        <i class="flaticon-delete-1"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td colspan="3"><strong class="text-primary"><u><span id="total"></span></u></strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('pharmacist.med_info')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group m-form__group row">
                    <div class="col-md-6">
                        <label for="recipient-name" class="form-control-label"><?php echo e(__('pharmacist.med_name')); ?></label><br>
                        <span><strong id="name"><?php echo e(__('pharmacist.pre_netUnavailable')); ?></strong></span>
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="form-control-label"><?php echo e(__('pharmacist.med_company')); ?></label><br>
                        <span><strong id="company"><?php echo e(__('pharmacist.pre_netUnavailable')); ?></strong></span>
                    </div>
                </div>    

                <div class="form-group m-form__group row">
                    <div class="col-md-6">
                        <label for="recipient-name" class="form-control-label"><?php echo e(__('pharmacist.med_excist')); ?></label><br>
                        <span><strong id="quantity"><?php echo e(__('pharmacist.pre_netUnavailable')); ?> </strong></span>
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="form-control-label"><?php echo e(__('pharmacist.med_type')); ?></label><br>
                        <span><strong id="type"><?php echo e(__('pharmacist.pre_netUnavailable')); ?></strong></span>
                    </div>
                </div>    

                <div class="form-group m-form__group row">
                    <div class="col-md-12">
                        <label for="recipient-name" class="form-control-label"><?php echo e(__('pharmacist.med_price')); ?></label><br>
                        <span><strong id="price"><?php echo e(__('pharmacist.pre_netUnavailable')); ?></strong></span>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="thanks" data-dismiss="modal"><?php echo e(__('pharmacist.pre_thanks')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('plugins'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/messages_' . app()->getLocale() . '.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

    var globalModal;

    $('#save-button').click(function() {
        var form = $('#save-form');
        submitBtn = this

        paymentType = $('#payment_type').val();
        if(paymentType == 'later')
            form.attr('action', '<?php echo e(route("surpres.store")); ?>')
            
        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });

        form.validate();
        if (form.valid())
            form.submit();
    });


    $(document).ready(function() {
        $('#patient').select2({
            placeholder: '<?php echo e(__('reception.rec_search')); ?>',
            minimumInputLength: 5,
            dir: '<?php echo e(app()->getLocale() == "en" ? "ltr" : "rtl"); ?>',
            ajax: {
                url: "<?php echo e(route('patient.filter')); ?>",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function(term) {
                    return {term : term.term, relation:'prescriptions', waitForApproval : true};
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            var approval = item.prescriptions.length > 0 ? item.prescriptions[0] : null;

                            approval = approval !== null && approval.approve.length > 0 ? approval.approve[0] : null;

                            var itemText = item.record_no + ' (' + item.name + ')';

                            if(approval)
                                itemText += ' <?php echo e(__("global.notPaidYet")); ?>';

                            var hasSurpres = (item.surpres.length > 0) ? true : false;
                            
                            hasSurpres = item.surpres.approve === undefined || item.surpres.approve.length == 0 ? true : false

                            if(hasSurpres)
                                itemText += ' <?php echo e(__("global.hasSurpres")); ?>';

                            return {
                                text: itemText,
                                slug: item.record_no,
                                id: item.id,
                                disabled: approval !== null && approval.is_approved == null ? true : false
                            }
                        })
                    };
                }
            }
        });

        applySelect2();

    });

    function applySelect2() {
        $('.ownerInput').select2({
            // theme: "bootstrap",
            placeholder: "Required",
            minimumInputLength: 3,
            ajax: {
                url: "<?php echo e(route('medicine.filter.ajax')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return {
                        name: term.term
                    };
                },
                processResults: function(data) {
                    return {
                        // results: data
                        results: $.map(data, function(item) {
                            return {
                                text: item.name + ' (' + item.milligram + ' mg) (' + item.type.label_en + ')',
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    }

    function addNew(e) {
        var index = uuid();
        e.preventDefault();
        var inputsStart = '<tr>' +
            '<td><select required style="min-width:300px" class="ownerInput" onchange="pasteInfo(this, true);" name="items[' + index + '][medicine_id]"></select></td>' +
            '<td><input type="number" id="quantity" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][quantity]"></td>' +
            // '<td><input type="number" id="total-price" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][total_price]"></td>' +
            '<td><input type="number" tabindex="-1" readonly class="form-control" id="unit-price"></td>' +
            '<td><span class="form-control total" tabindex="-1" id="total-price">&nbsp;&nbsp;</span></td>' +
            '<td>' +
            '<button class="btn btn-info" tabindex="-1" onclick="event.preventDefault();pasteInfo(this)">' +
            '<i class="flaticon-questions-circular-button"></i>' +
            '</button>' +
            '</td>';

        var inputsEnd =
            '<td>' +
            '<button class="btn btn-danger" tabindex="-1" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>' +
            '</tr>'

        $('#tbody').append(inputsStart + inputsEnd);
        applySelect2();

    }

    function uuid() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    };

    function remove(obj, e) {
        e.preventDefault();
        $(obj).parents('tr').remove();
        total();
    }

    function pasteInfo(param, medicineChange) {
        globalModal = param;
        var medicineId = $(param).closest('tr').find('select').val();

        if (!medicineId && !medicineChange) {
            alert('Please select a medicine to see it\'s information.');
            return false;
        }

        $('#m_info').modal('toggle');

        mApp.block(".modal-body", {
            overlayColor: "#000000",
            type: "loader",
            message: "Loading ..."
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo e(route("medicine.show", [null])); ?>' + '/' + medicineId,
            dataType: 'json',
            success: function(data) {
                mApp.unblock('.modal-body');
                $('#m_info #name').text(data.name + ' (' + data.milligram + ') mg');
                $('#m_info #company').text(data.company);
                $('#m_info #quantity').text(data.store.quantity + ' ' + ('<?php echo e(app()->isLocale("en")); ?>' ? data.type.label_en : data.type.label_dr));
                $('#m_info #price').text(data.store.unit_price + ' ' + ('<?php echo e(app()->isLocale("en")); ?>' ? data.store.currency.label_en : data.store.currency.label_dr));
                $('#m_info #type').text(('<?php echo e(app()->isLocale("en")); ?>' ? data.type.label_en : data.type.label_dr));
                $(param).closest('tr').find('#unit-price').val(data.store.unit_price);
            }
        });
    }

    function calculateBU(param) {
        param = $(param);
        
        unitPrice = param.closest('tr').find('#unit-price');
        totalPrice = param.closest('tr').find('#total-price');

        if (!unitPrice.val())
            return false;
        
        totalPrice.text(roundUp(unitPrice.val() * param.val()));
        total();
        
    }

    function roundUp(num, precision) {
        // precision = Math.pow(10, precision)
        // return Math.ceil(num * precision) / precision
        return Math.round(num * 10) / 10;
    }

    function changeStatus(param) {
        var status = $(param).is(':checked');
        $('#doctor').prop("disabled", status);
    }

    function total()
    {
        var tHolders = $('.total');
        var total= 0;
        tHolders.each(function(key, item){
            total += +$(item).text();
        });
        tax = roundUp((total * 4) / 100);
        $('#total').html(total + tax);
    }

    $('#m_info').on('hidden.bs.modal', function() {
        $(globalModal).closest('tr').find('#quantity').focus();
    });

    $(document).keyup(function(e) {
        if(e.keyCode==13)
            $('.modal').modal('hide');
});
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/pharmacist-module/prescription/create.blade.php ENDPATH**/ ?>