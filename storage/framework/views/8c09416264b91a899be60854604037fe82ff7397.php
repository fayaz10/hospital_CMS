<?php $__env->startSection('styles'); ?>
<!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->

<!-- <link href="<?php echo e(asset('css/jexcel.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/jsuites.css')); ?>" rel="stylesheet"> -->
<style type="text/css">
    /* input {
        display: block !important;
        padding: 7px 2px !important;
        margin: 0 !important;
        width: 100% !important;
        border-radius: 0 !important; 
        line-height: 1 !important;
    }
    select {
        display: block !important;
        padding: 7px 2px !important;
        margin: 0 !important;
        width: 100% !important;
        border-radius: 0 !important;
        line-height: 1 !important;
    } */

    /* td {
        margin: 0 !important;
        padding: 0 !important;
    } */

    /* th button {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent;
        border: 0;
    } */
</style>
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
                         <?php echo e(__('pharmacist.med_addnewPurchase')); ?>

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
            <form action="<?php echo e(route('medicine-purchase.store')); ?>" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 ">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.med_infonewPurchase')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> <?php echo e(__('pharmacist.med_purchase_date')); ?></label>
                                        <input type="date" required value="<?php echo e(old('purchase_date', date('Y-m-d'))); ?>" name="purchase_date" required class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> <?php echo e(__('pharmacist.med_payment')); ?></label>
                                        <input type="text" required value="<?php echo e(old('remitter',app()->getLocale() == 'en' ? auth()->user()->name : auth()->user()->name_dr)); ?>" name="remitter" , required class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label"><?php echo e(__('pharmacist.med_indusCompany')); ?></label>
                                        <input type="text" value="<?php echo e(old('suppliers')); ?>" name="suppliers" class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span><?php echo e(__('pharmacist.med_currency')); ?></label>
                                        <select class="form-control m-input" name="currency_id">
                                            <?php $__currentLoopData = \App\Models\FinanceModule\Currency::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>">
                                                    <?php echo e(app()->getLocale() == 'en' ? $type->label_en : $type->label_dr); ?> (<?php echo e($type->symbol); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo e(__('pharmacist.med_medInfoPu')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th><?php echo e(__('pharmacist.med_name')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_quantity')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_totalPrice')); ?></th>
                                                <th> 48% <?php echo e(__('pharmacist.med_benefit')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_price')); ?></th>
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
                                                <td><select required style="width:200px" class="ownerInput" name="items[0][medicine_id]"></select></td>
                                                <td><input type="number" id="quantity" onchange="calculateBU(this)" required class="form-control" name="items[0][quantity]"></td>
                                                <td><input type="number" id="total-price" onchange="calculateBU(this)" required class="form-control" name="items[0][total_price]"></td>
                                                <!-- <td><input type="number" required class="form-control" name="items[0][benefits]"></td>
                                                <td><input type="number" required class="form-control" name="items[0][unit_price]"></td> -->
                                                <td><span class="form-control" id="benefits">&nbsp;&nbsp;</span></td>
                                                <td><span class="form-control" id="unit-price">&nbsp;&nbsp;</span></td>
                                                
                                                <td>
                                                    <button class="btn btn-info"
                                                    onclick="event.preventDefault();pasteInfo(this)">
                                                        <i class="flaticon-questions-circular-button"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" onclick="remove(this, event)">
                                                        <i class="flaticon-delete-1"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>
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
                <h5 class="modal-title" id="exampleModalLabel">Medicine Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Medicine Name:</label><br>
                    <span><strong id="name">Unable to get the content info.</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Medicine Company:</label><br>
                    <span><strong id="company">Unable to get the content info</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Available in Stock:</label><br>
                    <span><strong id="quantity">Unable to get the content info </strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Unit Price:</label><br>
                    <span><strong id="price">Unable to get the content info</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Medicine Type:</label><br>
                    <span><strong id="type">Unable to get the content info</strong></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thanks</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('plugins'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/messages_' . app()->getLocale() . '.js')); ?>"></script>
<!-- <script src="<?php echo e(asset('js/select2.min.js')); ?>"></script> -->
<!-- <script src="<?php echo e(asset('js/jexcel.js')); ?>"></script>
<script src="<?php echo e(asset('js/jsuites.js')); ?>"></script> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
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


    $(document).ready(function() {
        applySelect2();
        
    });

    function applySelect2() {
        $('.ownerInput').select2({
            // theme: "bootstrap",
            placeholder: "Required",
            minimumInputLength: 4,
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
                                text: item.name + ' (' + item.milligram + ') mg',
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
            '<td><select required style="width:200px" class="ownerInput" name="items[' + index + '][medicine_id]"></select></td>' +
            '<td><input type="number" id="quantity" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][quantity]"></td>' +
            '<td><input type="number" id="total-price" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][total_price]"></td>' +
            '<td><span class="form-control" id="benefits">&nbsp;&nbsp;</span></td>' +
            '<td><span class="form-control" id="unit-price">&nbsp;&nbsp;</span></td>' +
            '<td>' +
            '<button class="btn btn-info" onclick="event.preventDefault();pasteInfo(this)" '+
                // 'data-toggle="m-tooltip" '+
                // 'data-html="true" '+
                // 'data-original-title="<b>Panadol Charck 345 mg</b><br/>Stock Available = 908<br/>Unit price = 456<br/>Unit = Bottol<br/>Type = Syrup<br/>"
                '>'+
                '<i class="flaticon-questions-circular-button"></i>'+
            '</button>'+
            '</td>';

        var inputsEnd =
            '<td>' +
            '<button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>' +
            '</tr>'

        $('#tbody').append(inputsStart + inputsEnd);
        applySelect2();

    }

    function uuid() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    };

    function remove(obj, e) {
        e.preventDefault();
        console.log($(obj).parents('tr'));
        $(obj).parents('tr').remove();
    }

    function pasteInfo(param){
        var medicineId = $(param).closest('tr').find('select').val();
        if (!medicineId){alert('Please select a medicine to see it\'s information.'); return false;}
        
        $('#m_info').modal('toggle');

        mApp.block(".modal-body",{
            overlayColor:"#000000",type:"loader",message:"Loading ..."
        });
        
        $.ajax({ 
            type: 'GET', 
            url: '<?php echo e(route("medicine.show", [null])); ?>' +'/'+ medicineId, 
            dataType: 'json',
            success: function (data) { 
                mApp.unblock('.modal-body');
                $('#m_info #name').text(data.name + ' (' + data.milligram + ') mg');
                $('#m_info #company').text(data.company);
                $('#m_info #quantity').text(data.store.quantity + ' ' + data.type.label_en);
                $('#m_info #price').text(data.store.unit_price + ' ' + data.store.currency.label_en);
                $('#m_info #type').text(data.type.label_en);
            }
        });
    }

    function calculateBU(param){
        param = $(param);

        benefits = param.closest('tr').find('#benefits');
        unitPrice = param.closest('tr').find('#unit-price');


        var benefitsConstant = +'<?php echo e(config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"))); ?>';

        sibling = param.is('#quantity') ? param.closest('tr').find('#total-price') : param.closest('tr').find('#quantity');
        
        console.log(param.attr('id'));

        if (param.attr('id') == 'quantity'){

            percentageAmount = (+sibling.val() * benefitsConstant) / 100;

            unitPrice.text(roundUp((+sibling.val() + percentageAmount) / +param.val(), 1));

            benefits.text(roundUp((+sibling.val() + percentageAmount), 1));

        }else{

            percentageAmount = (+param.val() * benefitsConstant) / 100;

            unitPrice.text(roundUp((+param.val() + percentageAmount) / +sibling.val(), 1));

            benefits.text(roundUp((+param.val() + percentageAmount), 1));
        }
        

    }

    function roundUp(num, precision) {
        // precision = Math.pow(10, precision)
        // return Math.ceil(num * precision) / precision
        return Math.round(num * 10) / 10;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/pharmacist-module/purchase/create.blade.php ENDPATH**/ ?>