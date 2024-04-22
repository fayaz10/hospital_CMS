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
                        <span class="m-nav__link-text"> <?php echo e(__('global.gol_fpage')); ?></span>
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

            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-12 text-primary">
                            <h4><strong><?php echo e(__('global.edit_price_quantity')); ?></strong></h4>
                        </div>
                            <div class="col-md-8 col-lg-7">
                                <select name="search" id="quick-search" class="form-control">
                                </select>
                            </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <button type="button" class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            onclick="$('#save-form').submit(); $(this).addClass('m-loader m-loader--light m-loader--left')">
                            <?php echo e(__('global.gol_save')); ?> 
                            <i class="la la-check"></i>
                        </button>
                    </div>
                </div>
                <hr>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('pharmacist.med_number')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_name')); ?> (<?php echo e(__('pharmacist.med_milligram')); ?>)</th>
                        <th> <?php echo e(__('pharmacist.med_company')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_type')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_excist')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_unit')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_price')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_expire_date')); ?></th>
                        <th> &nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="<?php echo e(route('medicine.assign-multipe')); ?>" id="save-form" method="post">
                        <?php echo csrf_field(); ?>
                        <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(($medicines->currentPage() == 0 ? 1 :$medicines->currentPage() - 1) * $medicines ->perPage() + $key + 1); ?></td>
                            <td><?php echo e($medicine->name); ?> (<?php echo e(__('global.mg', ['mg' => $medicine->milligram])); ?>)</td>
                            <td><?php echo e($medicine->company); ?></td>
                            <td><?php echo e(app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr); ?></td>
                            <td>
                                <input type="number" class="form-control m-input " 
                                    placeholder="<?php echo e(__('pharmacist.med_excist')); ?>" 
                                    name="medicine[<?php echo e($medicine->id); ?>][quantity]"
                                    min="0"
                                    value="<?php echo e($medicine->store ? $medicine->store->quantity : null); ?>"
                                    aria-describedby="basic-addon2">
                            </td>
                            <td><span class="form-control"><?php echo e(app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr); ?></span></td>
                            <td>
                                <input type="number" class="form-control m-input " 
                                    placeholder="<?php echo e(__('pharmacist.med_price')); ?>"
                                    name="medicine[<?php echo e($medicine->id); ?>][unit_price]" 
                                    min="0"
                                    value="<?php echo e($medicine->store ? $medicine->store->unit_price : null); ?>"
                                    aria-describedby="basic-addon2">
                            </td>
                            <td>
                                <input type="date" class="form-control"
                                    name="medicine[<?php echo e($medicine->id); ?>][expire_date]"
                                    value="<?php echo e($medicine->expire_date); ?>">
                            </td>
                            <td><span class="form-control"><?php echo e(app()->getLocale() == 'en' ? $medicine->store->currency->label_en : $medicine->store->currency->label_dr); ?></span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </form>
                </tbody>
            </table>

            <?php echo e($medicines->appends(request()->only(['term']))->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '<?php echo e(__("global.search")); ?>',
            dir: '<?php echo e(app()->isLocale("en") ? "ltr" : "rtl"); ?>',
            minimumInputLength: 2,
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
                        results: $.map(data, function(item) {
                            return {
                                text: item.name ,
                                mg: item.milligram + ' mg',
                                company: item.company,
                                id: item.id
                            }
                        })
                    };
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        search.on("change", function (e) {
            var object = $(this).select2('data')[0];
            window.location.href = '<?php echo e(route("medicine.edit-multipe")); ?>' + '?term=' + object.text;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'>" + repo.mg + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''>" + repo.company + "</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/pharmacist-module/medicine/edit-multiple.blade.php ENDPATH**/ ?>