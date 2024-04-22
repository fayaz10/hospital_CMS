<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Expermint Bill</title>
    <style>
        @font-face {
            font-family: 'Sahel';
            src: url(<?php echo e(storage_path('fonts\Sahel.ttf')); ?>) format("truetype");
            font-weight: 300; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            font-style: normal; // use the matching font-style here
        }
        body {
            font-family: 'Sahel', Calibri, sans-serif;
            font-size: 12;
            margin-top: 200px;
            margin-bottom: 50px
        }

        table{
            width: 100%
        }

        td, th {
            vertical-align: top;
            text-align: left;
            border: 1px solid;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            <td> <?php echo e(__('lab.lab_expRecord_no')); ?> : <?php echo e($experiment->record_no); ?> </td>
            <td> <?php echo e(__('reception.pat_name')); ?> : (<?php echo e($experiment->patient->record_no); ?>) <?php echo e($experiment->patient->name); ?> </td>
            <td> <?php echo e(__('reception.pat_age')); ?> : <?php echo e($experiment->patient->age); ?> </td>
        </tr>
        <tr>
            <td> <?php echo e(__('reception.vis_doctors')); ?> : <?php echo e($experiment->doctor->name); ?> </td>
            <td> <?php echo e(__('reception.sex')); ?> : <?php echo e($experiment->patient->sex); ?> </td>
            <td> <?php echo e(__('global.date')); ?> : <?php echo e($experiment->created_at->format('Y-m-d g:s A')); ?></td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="3">
        <tr>
            <th width="30%">Description</th>
            <th width="40%">Reference Range</th>
            <th width="30%">Patient Value</th>
        </tr>
        <?php $__currentLoopData = $experiment->tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td> <?php echo e($test->name); ?> </td>
                <td colspan="2"> <?php echo $test->pivot->results; ?> </td>
                
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/lab-module/experiment/print-result.blade.php ENDPATH**/ ?>