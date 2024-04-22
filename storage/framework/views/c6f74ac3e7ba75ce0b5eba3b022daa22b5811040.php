<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('lab-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('lab.lab_mod')); ?></h3>
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
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('experiment.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="<?php echo e(route('experiment.create')); ?>">
                            <span> <i class="la la-plus"></i> <span><?php echo e(__('global.gol_create')); ?></span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <hr>

            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th><?php echo e(__('global.number')); ?></th>
                        <th><?php echo e(__('reception.pat_record')); ?></th>
                        <th><?php echo e(__('reception.vis_patent')); ?></th>
                        <th><?php echo e(__('reception.vis_doctors')); ?></th>
                        <th><?php echo e(__('lab.lab_testNums')); ?></th>
                        <th><?php echo e(__('pharmacist.pre_totalPayment')); ?></th>
                        <th> <?php echo e(__('admin.adm_state')); ?></th>
                        <th><?php echo e(__('global.approval')); ?></th>
                        <th><?php echo e(__('global.operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $experiments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $experiment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($experiments->currentPage() == 0 ? 1 :$experiments->currentPage() - 1) * $experiments ->perPage() + $key + 1); ?>

                        </td>
                        <td><?php echo e($experiment->record_no); ?></td>
                        <td><?php echo e($experiment->patient->name); ?>

                            <?php echo e(__('lab.lab_(') . $experiment->patient->record_no . __('lab.lab_)')); ?></td>
                        <td><?php echo e($experiment->doctor->name); ?></td>
                        <td><?php echo e($experiment->tests_count); ?>  </td>
                        <td>
                            <?php echo e($experiment->profit->totalAmount); ?>

                            <?php echo e(app()->getLocale() == 'en' ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr); ?>

                        </td>
                        <td>
                            <?php
                                $status = optional($experiment->approve)->map(function ($item, $key) {
                                    if ($item->is_approved === 1)
                                        return '<span class="text-success la la-check"></span>';

                                    if ($item->is_approved === null)
                                        return '<span class="text-info la la-minus"></span>';

                                    if ($item->is_approved === 0)
                                        return '<span class="text-danger la la-close"></span>';
                                    
                                });
                                
                                echo implode(' ', optional($status)->toArray())
                            ?>
                        </td>
                        <td><span
                                class="m-badge <?php echo e($experiment->is_approved ? 'm-badge--brand' : 'm-badge--danger'); ?> m-badge--wide">
                                <?php echo e($experiment->is_approved ? __('global.received') : __('global.pending')); ?>

                            </span></td>
                        <td>
                            <a href="#" onclick="deleteData('<?php echo e(route('experiment.destroy', $experiment->id)); ?>', event)"> <i
                                    class="text-danger flaticon-delete-2"></i></a>
                            &nbsp;
                            <a href="<?php echo e(route('experiment.edit', $experiment->id)); ?>">
                                <i class="flaticon-edit"></i>
                            </a>
                            &nbsp;
                            <a href="<?php echo e(route('experiment.show', [$experiment->id])); ?>">
                                <i class="flaticon-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($experiments->links()); ?>

        </div>
    </div>
</div>


<form method="post" style="display:none" action="" id="form-delete">
    <?php echo e(csrf_field()); ?>

    <?php echo e(method_field('delete')); ?>

</form>

<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('global.deletion')); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo e(__('global.deletion_message')); ?></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" 
                    class="btn btn-danger" 
                    onclick="document.getElementById('form-delete').submit();">
                        <?php echo e(__('global.yes')); ?>

                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo e(__('global.no')); ?>

                </button>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

    function deleteData(route, e)
    {
        e.preventDefault();
        $('#form-delete').attr('action', route);
        $('#m_modal_1').modal('show');
    }

    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: 'Search by record number',
            dir: '<?php echo e(app()->isLocale("en") ? "ltr" : "rtl"); ?>',
            minimumInputLength: 3,
            ajax: {
                url: "<?php echo e(route('experiment.search')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.record_no ,
                                name: item.patient.name,
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
            window.location.href = '<?php echo e(route("experiment.show", [null])); ?>' + '/' + object.id;
        });
    });

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var markup = "<div class='select2-result-repository__statistics'>" +
                "<div class='float-left'><strong>" + repo.text + "</strong></div>" +
                "<div class='float-right'> </i>" + repo.name + "</div>" +
                "<div class='clear-both'></div><br>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo) {
        return repo.text;
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/lab-module/experiment/index.blade.php ENDPATH**/ ?>