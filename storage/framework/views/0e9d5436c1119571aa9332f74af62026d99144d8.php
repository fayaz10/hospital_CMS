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

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <select name="search" id="quick-search" class="form-control">
                        </select>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('medicine.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="btn-group">
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('medicine.create')); ?>">
                                <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                                </span>
                            </a>
                            <button type="button" class="btn  btn-focus m-btn--air dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">
                                    <?php echo e(__('global.gol_more_options')); ?>

                                </span>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(80px, 40px, 0px);">
                                <a class="dropdown-item" href="<?php echo e(route('medicine.create') .'?multiple'); ?>">
                                    <?php echo e(__('global.gol_create_multiple')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('medicine.edit-multipe')); ?>">
                                    <?php echo e(__('global.edit_multiple')); ?>

                                </a>
                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('pharmacist.med_number')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_name')); ?></th>
                        <th><?php echo e(__('pharmacist.med_milligram')); ?> </th>
                        <th> <?php echo e(__('pharmacist.med_type')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_company')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_excist')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_price')); ?></th>
                        <th> <?php echo e(__('pharmacist.med_expire_date')); ?></th>
                        <th><?php echo e(__('pharmacist.med_operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e(optional($medicine->expire_date)->lte(now()->addMonths(3)) ? 'm-table__row--warning' : null); ?>">
                        <td><?php echo e(($medicines->currentPage() == 0 ? 1 :$medicines->currentPage() - 1) * $medicines ->perPage() + $key + 1); ?></td>
                        <td><?php echo e($medicine->name); ?></td>
                        <td><?php echo e($medicine->milligram); ?></td>
                        <td><?php echo e(app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr); ?></td>
                        <td><?php echo e($medicine->company); ?></td>
                        <td>
                            <?php if($medicine->store): ?>
                            <?php echo e($medicine->store->quantity); ?>

                            <?php else: ?>
                            0
                            <?php endif; ?>
                            <?php echo e(app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr); ?>

                        </td>
                        <td>
                            <?php if($medicine->store): ?>
                            <?php echo e($medicine->store->unit_price); ?> <?php echo e(app()->getLocale() == 'en' ? $medicine->store->currency->label_en : $medicine->store->currency->label_dr); ?>

                            <?php else: ?>
                            Undefined
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(optional($medicine->expire_date)->format('Y-m-d')); ?></td>
                        <td>
                            <a href="<?php echo e(route('medicine.show', [$medicine->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo e(route('medicine.edit', $medicine->id)); ?>">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($medicines->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '<?php echo e(__("global.search")); ?>',
            dir: '<?php echo e(app()->isLocale("en") ? "ltr" : "rtl"); ?>',
            minimumInputLength: 2,
            ajax: {
                url: "<?php echo e(route('medicine.search')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
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
            window.location.href = '<?php echo e(route("medicine.show", [null])); ?>' + '/' + object.id;
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/pharmacist-module/medicine/index.blade.php ENDPATH**/ ?>