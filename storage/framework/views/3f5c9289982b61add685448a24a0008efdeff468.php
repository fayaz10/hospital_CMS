<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/Chart.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

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
    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <?php echo e(__('global.gol_docy')); ?>

                                </span>
                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                <?php echo e($doctorsCount); ?>

                            </span>
                            <span class="m-widget24__desc">
                                <span class="text-primary">
                                </span> <?php echo e(__('reception.docies')); ?>

                                <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <?php echo e(__('reception.visit')); ?>

                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                <?php echo e($patientsInthisDayCount); ?>

                            </span>
                            <span class="m-widget24__desc">
                                <?php echo e(__('reception.visitToday')); ?>


                                <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <?php echo e(__('reception.visit')); ?>

                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                <?php echo e($patientsInthisWeekCount); ?>

                            </span>
                            <span class="m-widget24__desc">
                                <?php echo e(__('reception.visitWeek')); ?>

                            </span>

                            <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <?php echo e(__('reception.visit')); ?>

                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                <?php echo e($patientsInthisMonthCount); ?>

                            </span>
                            <span class="m-widget24__desc">
                                <?php echo e(__('reception.visitMonth')); ?>

                            </span>

                            <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        <strong><?php echo e(__('reception.vis_graph')); ?></strong>
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
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugins'); ?>
<script src="<?php echo e(asset('js/Chart.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(route('receptionis.visit-graph', ['sub' => 5])); ?>",
            dataType: 'json',
            type: "get",
            success: function(response) {
                loadChart(response.months, response.data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.');
            }
        });
    });


    function loadChart(labels, data) {
        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '<?php echo e(__("reception.vis_label")); ?>',
                    // backgroundColor: '#691F91',
                    borderColor: '#8527B7',
                    data: data,
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyWebs\hosys\hosys\hosys\resources\views/receptionist-module/dashboard.blade.php ENDPATH**/ ?>