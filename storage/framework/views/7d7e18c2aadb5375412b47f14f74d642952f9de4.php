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
                        <span class="m-nav__link-text"><?php echo e(__('finance.sideDiverseIncome')); ?></span>
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

            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-8 col-lg-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="<?php echo e(route('din.filter')); ?>" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span><?php echo e(__('global.filter')); ?></span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="<?php echo e(route('din.create')); ?>">
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
                        <th><?php echo e(__('pharmacist.med_number')); ?></th>
                        <th> <?php echo e(__('finance.incSection')); ?></th>
                        <th> <?php echo e(__('finance.dCategory')); ?></th>
                        <th> <?php echo e(__('finance.dSubject')); ?></th>
                        <th> <?php echo e(__('finance.dType')); ?></th>
                        <th> <?php echo e(__('reception.pay_tax')); ?></th>
                        <th> <?php echo e(__('reception.amountOfPayament')); ?></th>
                        <th><?php echo e(__('reception.pay_discount')); ?>

                        <th> <?php echo e(__('lab.lab_expCreatedAt')); ?></th>
                        <th><?php echo e(__('pharmacist.med_operation')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($incomes->currentPage() == 0 ? 1 :$incomes->currentPage() - 1) * $incomes ->perPage() + $key + 1); ?></td>
                    <td><?php echo e(__('finance.'.strtolower(basename($income->profit->profitable_type, '\\')))); ?></td>
                    <td>
                        <?php echo e(app()->getLocale() == 'en' ? $income->category->label_en : $income->category->label_dr); ?>

                    </td>
                    <td><?php echo e($income->subject); ?></td>
                    <td><?php echo e(__("finance.{$income->type}")); ?></td>
                    <td>
                        <?php echo e($income->profit->taxes); ?>

                        <?php echo e(app()->getLocale() == 'en' ? $income->profit->currency->label_en : $income->profit->currency->label_dr); ?>

                    </td>
                    <td>
                        <?php echo e($income->profit->totalAmount); ?>

                        <?php echo e(app()->getLocale() == 'en' ? $income->profit->currency->label_en : $income->profit->currency->label_dr); ?>

                    </td>
                    <td><?php echo e($income->discount ? $income->discount . '%' : '-'); ?></td>
                    <td><?php echo e($income->created_at->format('Y-m-d g:i A')); ?></td>

                    <td>
                        <a href="#" onclick="deleteData('<?php echo e(route('din.destroy', $income->id)); ?>', event)"> <i
                                    class="text-danger flaticon-delete-2"></i></a>
                            &nbsp;
                        <a href="<?php echo e(route('din.edit', [$income->id])); ?>">
                            <i class="flaticon-edit"></i>
                        </a>
                        &nbsp;
                        <a href="<?php echo e(route('din.show', [$income->id])); ?>">
                            <i class="flaticon-eye"></i>
                        </a>
                    </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php echo e($incomes->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


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


<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '<?php echo e(__("global.search")); ?>',
            dir: '<?php echo e(app()->isLocale("en") ? "ltr" : "rtl"); ?>',
            minimumInputLength: 2,
            ajax: {
                url: "<?php echo e(route('din.search')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.subject,
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

        search.on("change", function(e) {
            var object = $(this).select2('data')[0];
            window.location.href = '<?php echo e(route("din.show", [null])); ?>' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><strong>" + repo.text + "</strong></div>" +
            // "<div class='float-right'>  <i class='flaticon-coins'> </i>" + repo.price + "</div>" +
            "<div class='clear-both'></div><br>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }

    function deleteData(route, e)
    {
        e.preventDefault();
        $('#form-delete').attr('action', route);
        $('#m_modal_1').modal('show');
    }
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/receptionist-module/din/index.blade.php ENDPATH**/ ?>