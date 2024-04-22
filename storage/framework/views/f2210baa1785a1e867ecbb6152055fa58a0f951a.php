<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('finance-module.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"><?php echo e(__('finance.finance-module')); ?></h3>
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

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        <strong><?php echo e(__('finance.incExpGraph')); ?></strong>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div style="width:100%;">
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <strong><?php echo e(__('finance.incGraph')); ?></strong>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div style="width:100%;">
                        <canvas id="income-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <strong><?php echo e(__('finance.expGraph')); ?></strong>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div style="width:100%;">
                        <canvas id="expense-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugins'); ?>
<script src="<?php echo e(asset('js/Chart.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    var COLORS = ['#7b1fa2', '#c2185b', '#512da8', '#0097a7', '#00796b', '#0288d1', '#388e3c', '#689f38', '#1976d2', '#afb42b', '#455a64', '#5d4037', '#303f9f', '#e64a19'];
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(route('finance.in-ex-graph', ['sub' => 3])); ?>",
            dataType: 'json',
            type: "get",
            success: function(response) {
                loadChart(response.months, response.income, response.expense);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.');
            }
        });

        $.ajax({
            url: "<?php echo e(route('finance.income-graph', ['sub' => 1])); ?>",
            dataType: 'json',
            type: "get",
            success: function(response) {
                loadIncomeChart(response.incomeTypes, response.incomeData);
                loadExpenseChart(response.expenseTypes, response.expenseData);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.');
            }
        });
    });


    function loadChart(months, incomeData, expenseData) {
        var config = {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: '<?php echo e(__("finance.incomes")); ?>',
                    backgroundColor: '#8527B7',
                    borderColor: '#8527B7',
                    data: incomeData,
                    fill: true,
                }, {
                    label: '<?php echo e(__("finance.expenses")); ?>',
                    backgroundColor: '#c62828',
                    borderColor: '#c62828',
                    data: expenseData,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '<?php echo e(__("reception.months")); ?>'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '<?php echo e(__("reception.values")); ?>'
                        }
                    }]
                }
            }
        };

        var ctx = $('#canvas');
        var myLine = new Chart(ctx, config);
    }


    function loadExpenseChart(types, expenseData) {
        var config = {
            type: 'pie',
            data: {
                labels: types,
                datasets: [{
                    // label: '<?php echo e(__("finance.incomes")); ?>',
                    backgroundColor: COLORS.reverse(),
                    // borderColor: '#8527B7',
                    data: expenseData,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
            }
        };

        var ctx = $('#expense-chart');
        var myLine = new Chart(ctx, config);
    }


    function loadIncomeChart(types, incomeData) {
        var config = {
            type: 'pie',
            data: {
                labels: types,
                datasets: [{
                    // label: '<?php echo e(__("finance.incomes")); ?>',
                    backgroundColor: COLORS,
                    // borderColor: '#8527B7',
                    data: incomeData,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
            }
        };

        var ctx = $('#income-chart');
        var myLine = new Chart(ctx, config);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hosys\resources\views/finance-module/home.blade.php ENDPATH**/ ?>