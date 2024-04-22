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
                        <div class="col-md-8 col-lg-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="<?php echo e(route('patient.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('global.number')); ?></th>
                        <th><?php echo e(__('reception.pat_name')); ?></th>
                        <th><?php echo e(__('reception.sex')); ?></th>
                        <th><?php echo e(__('reception.pat_record')); ?></th>
                        <th><?php echo e(__('reception.pat_age')); ?></th>
                        <th><?php echo e(__('reception.pat_phone')); ?></th>
                        <th><?php echo e(__('global.gol_cret')); ?></th>
                        <th><?php echo e(__('global.operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(app()->getLocale() == 'dr'){
                    setlocale(LC_TIME, 'fa_IR');
                    Carbon\Carbon::setLocale('fa');
                    }
                    ?>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($patients->currentPage() == 0 ? 1 :$patients->currentPage() - 1) * $patients ->perPage() + $key + 1); ?></td>
                        <td><?php echo e($patient->name); ?></td>
                        <td><?php echo e(__("reception.{$patient->sex}")); ?></td>
                        <td><?php echo e($patient->record_no); ?></td>
                        <td><?php echo e($patient->age); ?></td>
                        <td><?php echo e($patient->phone_no); ?></td>
                        <td><?php echo e($patient->created_at ? $patient->created_at->diffForHumans() : 'N/A'); ?></td>
                        <td>
                            <a href="<?php echo e(route('patient.show', [$patient->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo e(route('patient.edit', $patient->id)); ?>">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($patients->links()); ?>

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
                url: "<?php echo e(route('patient.search')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name + ' (' + item.record_no + ')',
                                record: item.record_no,
                                age: item.age,
                                phone: item.phone_no,
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
            window.location.href = '<?php echo e(route("patient.show", [null])); ?>' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><i class='la la-user'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'> <?php echo e(__('reception.pat_age')); ?> : " + repo.age + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''><i class='la la-phone'></i> <small>" + repo.phone + "</small></div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/receptionist-module/patient/index.blade.php ENDPATH**/ ?>