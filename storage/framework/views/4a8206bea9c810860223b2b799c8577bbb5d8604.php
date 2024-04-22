<?php $__env->startSection('styles'); ?>
<!-- <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('pharmacist-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> <?php echo e(__('pharmacist.med_module')); ?></h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href=" <?php echo e(route('medicine.index')); ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('global.gol_fpageMed')); ?></span>
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

                <!-- here can place a pprogress bar-->
            </div>
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="la la-user"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            <?php echo e(__('global.gol_create_multiple')); ?>

                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="<?php echo e(route('medicine.index')); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
            <form action="<?php echo e(route('medicine.store') . '?multiple'); ?>" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                <?php echo e(csrf_field()); ?>

                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <?php echo $__env->make('errors.validation-errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"> <?php echo e(__('pharmacist.med_newMed')); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th><i class="text-danger">*</i> <?php echo e(__('pharmacist.med_name')); ?></th>
                                                <th><i class="text-danger">*</i> <?php echo e(__('pharmacist.med_milligram')); ?></th>
                                                <th><i class="text-danger">*</i> <?php echo e(__('pharmacist.med_company')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_excistNow')); ?></th>
                                                <th><?php echo e(__('pharmacist.med_price')); ?></th>
                                                <th><i class="text-danger">*</i> <?php echo e(__('pharmacist.med_type')); ?></th>
                                                <th><i class="text-danger">*</i> <?php echo e(__('pharmacist.med_unit')); ?></th>
                                                <th>
                                                    <button class="btn btn-primary" onclick="addNew(event)">
                                                        <i class="flaticon-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td><select required style="min-width:200px" class="ownerInput" name="items[0][name]"></select></td>
                                                <td><input type="number" required class="form-control" name="items[0][milligram]"></td>
                                                <td><input type="text" required class="form-control" name="items[0][company]"></td>
                                                <td><input type="number" class="form-control" name="items[0][quantity]"></td>
                                                <td><input type="number" class="form-control" name="items[0][unit_price]"></td>
                                                <td style="min-width:130px">
                                                    <select class="form-control m-input" name="items[0][type_id]">
                                                        <?php $__currentLoopData = \App\Models\Pharmacist\MedicineType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($type->id); ?>" <?php echo e(old("type_id") == $type->id ? "selected" : ""); ?>>
                                                            <?php echo e(app()->isLocale("en") ? $type->label_en : $type->label_dr); ?>

                                                        </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </td>
                                                <td style="min-width:130px">
                                                    <select class="form-control m-input" name="items[0][unit_id]">
                                                        <?php $__currentLoopData = \App\Models\Pharmacist\Unit::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($unit->id); ?>" <?php echo e(old("unit_id") == $unit->id ? "selected" : ""); ?>> <?php echo e(app()->isLocale("en") ? $unit->label_en : $unit->label_dr); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>
                                            </tr>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('plugins'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/messages_' . app()->getLocale() . '.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
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
            tags: true,
            createSearchChoice: function(term, data) {
                if ($(data).filter(function() {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                    return {
                        id: term,
                        text: term
                    };
                }
            },
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
            '<td><select required style="width:200px" class="ownerInput" name="items[' + index + '][name]"></select></td>' +
            '<td><input type="number" required class="form-control" name="items[' + index + '][milligram]"></td>' +
            '<td><input type="text" required class="form-control" name="items[' + index + '][company]"></td>' +
            '<td><input type="number" class="form-control" name="items[' + index + '][quantity]"></td>' +
            '<td><input type="number" class="form-control" name="items[' + index + '][unit_price]"></td>' +
            '<td> <select class="form-control m-input" name="items[' + index + '][type_id]"> <?php $__currentLoopData = \App\Models\Pharmacist\MedicineType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($type->id); ?>"<?php echo e(old("type_id")==$type->id ? "selected" : ""); ?>><?php echo e(app()->isLocale("en") ? $type->label_en : $type->label_dr); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> </td>' +
            '<td> <select class="form-control m-input" name="items[' + index + '][unit_id]"> <?php $__currentLoopData = \App\Models\Pharmacist\Unit::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($unit->id); ?>"<?php echo e(old("unit_id")==$unit->id ? "selected" : ""); ?>><?php echo e(app()->isLocale("en") ? $unit->label_en : $unit->label_dr); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> </td>';
        
        var inputsEnd =
            '<td>' +
            '<button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>' +
            '</tr>';

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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/pharmacist-module/medicine/create-multiple.blade.php ENDPATH**/ ?>