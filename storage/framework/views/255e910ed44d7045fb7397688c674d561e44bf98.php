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
    <div class="m-portlet m-portlet--mobile">
        <?php if (\Entrust::can('rec_apr_show')) : ?>
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-md-4 order-2 order-xl-1">
                        <select name="search" id="quick-search" class="form-control">
                        </select>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        
                        
                    </div>
                </div>
            </div>
            <hr>
            <?php echo $__env->make('errors.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <ul class="nav nav-tabs mt-3" role="tablist">
                <?php if(!is_null($searches)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($tab == 'search' ? 'active show' : ''); ?>" data-toggle="tab" href="#search">
                            <h5><?php echo e(__('global.quickResult')); ?></h5>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($tab == 'all-approvales' ? 'active show' : ''); ?>" data-toggle="tab" href="#approvales">
                        <h5><?php echo e(__('global.allApprovales')); ?></h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($tab == 'pending' ? 'active show' : ''); ?>" data-toggle="tab" href="#pending">
                        <h5><?php echo e(__('global.waitingAppr')); ?></h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($tab == 'approved' ? 'active show' : ''); ?>" data-toggle="tab" href="#approved">
                        <h5><?php echo e(__('global.paidAppr')); ?></h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($tab == 'rejected' ? 'active show' : ''); ?>" data-toggle="tab" href="#rejected">
                        <h5><?php echo e(__('global.rejectedAppr')); ?></h5>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                
                <?php if(!is_null($searches)): ?>
                    <div class="tab-pane <?php echo e($tab == 'search' ? 'active show' : ''); ?>" id="search" role="tabpanel">

                        <table class="table m-table m-table--head-separator-primary">
                            <thead class="table-inverse">
                                <tr>
                                    <th><?php echo e(__('global.number')); ?></th>
                                    <th><?php echo e(__('finance.incSection')); ?></th>
                                    <th><?php echo e(__('reception.pat_name')); ?></th>
                                    <th><?php echo e(__('finance.total_paid')); ?></th>
                                    <th><?php echo e(__('reception.pat_regdate')); ?></th>
                                    <th><?php echo e(__('admin.adm_state')); ?></th>
                                    <th><?php echo e(__('reception.approval_date')); ?></th>
                                    <th colspan="4"><?php echo e(__('global.operation')); ?></th>
                                </tr>
                            </thead>
                            <?php
                            if(app()->getLocale() == 'dr'){
                                setlocale(LC_TIME, 'fa_IR');
                                Carbon\Carbon::setLocale('fa');
                            $currency = \App\Models\FinanceModule\Currency::pluck('label_dr', 'id')->toArray();
                            }else{
                                $currency = \App\Models\FinanceModule\Currency::pluck('label_en', 'id')->toArray();
                            }
                            // dd($currency)
                            ?>
                            <tbody>
                                <?php $__currentLoopData = $searches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($income->type == 'refund'): ?>
                                    <tr class="m-table__row--warning">
                                <?php elseif($income->type == 'payment'): ?>
                                    <tr class="m-table__row--success">
                                <?php else: ?>
                                    <tr>
                                <?php endif; ?> 
                                
                                
                                    <td><?php echo e(($searches->currentPage() == 0 ? 1 :$searches->currentPage() - 1) * $searches ->perPage() + $key + 1); ?>

                                    </td>
                                    <td><?php echo e(__('finance.'.strtolower(basename($income->approvable_type, '\\')))); ?></td>
                                    <td><?php echo e($income->record_no); ?></td>
                                    <td><?php echo e($income->amount); ?> <?php echo e($currency[$income->currency_id]); ?></td>
                                    <td><?php echo e($income->created_at->diffForHumans()); ?></td>
                                    <td>
                                        <?php if($income->is_approved == 1): ?>
                                        <span class="m-badge m-badge--brand m-badge--wide">
                                            <?php echo e(__('global.received')); ?>

                                        </span>
                                        <?php elseif(is_null($income->is_approved)): ?>
                                        <span class="m-badge m-badge--danger m-badge--wide">
                                            <?php echo e(__('global.pending')); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="m-badge m-badge--dark m-badge--wide">
                                            <?php echo e(__('global.rejected')); ?>

                                        </span>
                                        <?php endif; ?>
                                        
                                    </td>
                                    <td>
                                        <?php echo e($income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : ''); ?>

            
                                    </td>
            
                                    <td width="90px">
                                        <?php if($income->is_approved == true): ?>
                                            <?php if($income->approvable_type == 'App\Models\Pharmacist\Prescription'): ?>
                                                <a href="<?php echo e(route('rec.pres.print', $income->approvable_id)); ?>">
                                                    <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                        <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                    </button>
                                                </a>
                                            <?php elseif($income->approvable_type == 'App\Models\LabModule\Experiment'): ?>
                                                <a href="<?php echo e(route('rec.expr.print', $income->approvable_id)); ?>">
                                                    <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                        <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                    </button>
                                                </a>
                                            <?php elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription'): ?>
                                                <a href="<?php echo e(route('rec.surpre.print', $income->approvable_id)); ?>">
                                                    <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                        <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                    </button>
                                                </a>
                                            <?php endif; ?>
                                            
                                        <?php endif; ?>
                                    </td>
            
                                    <td width="90px">
                                        <button class="btn btn-primary <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="approve('<?php echo e(route('approval.approve', $income->id)); ?>', event)">
                                            <i class="fa fa-check"></i> &nbsp;<?php echo e(__('global.approve')); ?>

                                        </button>
                                    </td>
                                    <td width="90px">
                                        <button class="btn btn-danger <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="reject('<?php echo e(route('approval.reject', $income->id)); ?>', event)">
                                            <i class="fa fa-times"></i> &nbsp;<?php echo e(__('global.reject')); ?>

                                        </button>
                                    </td>
                                    <td width="90px">
                                        <a href="<?php echo e($income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#'); ?>">
                                            <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                <i class="flaticon-eye"></i> &nbsp;<?php echo e(__('global.view')); ?>

                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
            
                        <?php echo e($searches->appends(array_merge($_GET, ['tab' => 'search']))->links()); ?>

                    </div>
                <?php endif; ?>
                
                <div class="tab-pane <?php echo e($tab == 'all-approvales' ? 'active show' : ''); ?>" id="approvales" role="tabpanel">

                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th><?php echo e(__('global.number')); ?></th>
                                <th><?php echo e(__('finance.incSection')); ?></th>
                                <th><?php echo e(__('reception.pat_name')); ?></th>
                                <th><?php echo e(__('finance.total_paid')); ?></th>
                                <th><?php echo e(__('reception.pat_regdate')); ?></th>
                                <th><?php echo e(__('admin.adm_state')); ?></th>
                                <th><?php echo e(__('reception.approval_date')); ?></th>
                                <th colspan="4"><?php echo e(__('global.operation')); ?></th>
                            </tr>
                        </thead>
                        <?php
                        if(app()->getLocale() == 'dr'){
                            setlocale(LC_TIME, 'fa_IR');
                            Carbon\Carbon::setLocale('fa');
                        $currency = \App\Models\FinanceModule\Currency::pluck('label_dr', 'id')->toArray();
                        }else{
                            $currency = \App\Models\FinanceModule\Currency::pluck('label_en', 'id')->toArray();
                        }
                        // dd($currency)
                        ?>
                        <tbody>
                            <?php $__currentLoopData = $approvables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($income->type == 'refund'): ?>
                                <tr class="m-table__row--warning">
                            <?php elseif($income->type == 'payment'): ?>
                                <tr class="m-table__row--success">
                            <?php else: ?>
                                <tr>
                            <?php endif; ?> 
                            
                            
                                <td><?php echo e(($approvables->currentPage() == 0 ? 1 :$approvables->currentPage() - 1) * $approvables ->perPage() + $key + 1); ?>

                                </td>
                                <td><?php echo e(__('finance.'.strtolower(basename($income->approvable_type, '\\')))); ?></td>
                                <td><?php echo e($income->record_no); ?></td>
                                <td><?php echo e($income->amount); ?> <?php echo e($currency[$income->currency_id]); ?></td>
                                <td><?php echo e($income->created_at->diffForHumans()); ?></td>
                                <td>
                                    <?php if($income->is_approved == 1): ?>
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        <?php echo e(__('global.received')); ?>

                                    </span>
                                    <?php elseif(is_null($income->is_approved)): ?>
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        <?php echo e(__('global.pending')); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        <?php echo e(__('global.rejected')); ?>

                                    </span>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e($income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : ''); ?>

        
                                </td>
        
                                <td width="90px">
                                    <?php if($income->is_approved == true): ?>
                                        <?php if($income->approvable_type == 'App\Models\Pharmacist\Prescription'): ?>
                                            <a href="<?php echo e(route('rec.pres.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\LabModule\Experiment'): ?>
                                            <a href="<?php echo e(route('rec.expr.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription'): ?>
                                            <a href="<?php echo e(route('rec.surpre.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="approve('<?php echo e(route('approval.approve', $income->id)); ?>', event)">
                                        <i class="fa fa-check"></i> &nbsp;<?php echo e(__('global.approve')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="reject('<?php echo e(route('approval.reject', $income->id)); ?>', event)">
                                        <i class="fa fa-times"></i> &nbsp;<?php echo e(__('global.reject')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="<?php echo e($income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#'); ?>">
                                        <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                            <i class="flaticon-eye"></i> &nbsp;<?php echo e(__('global.view')); ?>

                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
        
                    <?php echo e($approvables->appends(array_merge($_GET, ['tab' => 'all-approvales']))->links()); ?>

                </div>
                <div class="tab-pane <?php echo e($tab == 'pending' ? 'active show' : ''); ?>" id="pending" role="tabpanel">

                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th><?php echo e(__('global.number')); ?></th>
                                <th><?php echo e(__('finance.incSection')); ?></th>
                                <th><?php echo e(__('reception.pat_name')); ?></th>
                                <th><?php echo e(__('finance.total_paid')); ?></th>
                                <th><?php echo e(__('reception.pat_regdate')); ?></th>
                                <th><?php echo e(__('admin.adm_state')); ?></th>
                                <th><?php echo e(__('reception.approval_date')); ?></th>
                                <th colspan="4"><?php echo e(__('global.operation')); ?></th>
                            </tr>
                        </thead>
                        <?php
                        ?>
                        <tbody>
                            <?php $__currentLoopData = $pendingApprovales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($income->type == 'refund'): ?>
                                <tr class="m-table__row--warning">
                            <?php elseif($income->type == 'payment'): ?>
                                <tr class="m-table__row--success">
                            <?php else: ?>
                                <tr>
                            <?php endif; ?> 
                            
                            
                                <td><?php echo e(($pendingApprovales->currentPage() == 0 ? 1 : $pendingApprovales->currentPage() - 1) * $pendingApprovales ->perPage() + $key + 1); ?>

                                </td>
                                <td><?php echo e(__('finance.'.strtolower(basename($income->approvable_type, '\\')))); ?></td>
                                <td><?php echo e($income->record_no); ?></td>
                                <td><?php echo e($income->amount); ?> <?php echo e($currency[$income->currency_id]); ?></td>
                                <td><?php echo e($income->created_at->diffForHumans()); ?></td>
                                <td>
                                    <?php if($income->is_approved == 1): ?>
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        <?php echo e(__('global.received')); ?>

                                    </span>
                                    <?php elseif(is_null($income->is_approved)): ?>
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        <?php echo e(__('global.pending')); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        <?php echo e(__('global.rejected')); ?>

                                    </span>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e($income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : ''); ?>

        
                                </td>
        
                                <td width="90px">
                                    <?php if($income->is_approved == true): ?>
                                        <?php if($income->approvable_type == 'App\Models\Pharmacist\Prescription'): ?>
                                            <a href="<?php echo e(route('rec.pres.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\LabModule\Experiment'): ?>
                                            <a href="<?php echo e(route('rec.expr.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription'): ?>
                                            <a href="<?php echo e(route('rec.surpre.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="approve('<?php echo e(route('approval.approve', $income->id)); ?>', event)">
                                        <i class="fa fa-check"></i> &nbsp;<?php echo e(__('global.approve')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="reject('<?php echo e(route('approval.reject', $income->id)); ?>', event)">
                                        <i class="fa fa-times"></i> &nbsp;<?php echo e(__('global.reject')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="<?php echo e($income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#'); ?>">
                                        <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                            <i class="flaticon-eye"></i> &nbsp;<?php echo e(__('global.view')); ?>

                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
        
                    <?php echo e($pendingApprovales->appends(array_merge($_GET, ['tab' => 'pending']))->links()); ?>

                </div>
                <div class="tab-pane <?php echo e($tab == 'approved' ? 'active show' : ''); ?>" id="approved" role="tabpanel">
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th><?php echo e(__('global.number')); ?></th>
                                <th><?php echo e(__('finance.incSection')); ?></th>
                                <th><?php echo e(__('reception.pat_name')); ?></th>
                                <th><?php echo e(__('finance.total_paid')); ?></th>
                                <th><?php echo e(__('reception.pat_regdate')); ?></th>
                                <th><?php echo e(__('admin.adm_state')); ?></th>
                                <th><?php echo e(__('reception.approval_date')); ?></th>
                                <th colspan="4"><?php echo e(__('global.operation')); ?></th>
                            </tr>
                        </thead>
                        <?php
                        ?>
                        <tbody>
                            <?php $__currentLoopData = $approvedPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($income->type == 'refund'): ?>
                                <tr class="m-table__row--warning">
                            <?php elseif($income->type == 'payment'): ?>
                                <tr class="m-table__row--success">
                            <?php else: ?>
                                <tr>
                            <?php endif; ?> 
                            
                            
                                <td><?php echo e(($approvedPayments->currentPage() == 0 ? 1 : $approvedPayments->currentPage() - 1) * $approvedPayments ->perPage() + $key + 1); ?>

                                </td>
                                <td><?php echo e(__('finance.'.strtolower(basename($income->approvable_type, '\\')))); ?></td>
                                <td><?php echo e($income->record_no); ?></td>
                                <td><?php echo e($income->amount); ?> <?php echo e($currency[$income->currency_id]); ?></td>
                                <td><?php echo e($income->created_at->diffForHumans()); ?></td>
                                <td>
                                    <?php if($income->is_approved == 1): ?>
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        <?php echo e(__('global.received')); ?>

                                    </span>
                                    <?php elseif(is_null($income->is_approved)): ?>
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        <?php echo e(__('global.pending')); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        <?php echo e(__('global.rejected')); ?>

                                    </span>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e($income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : ''); ?>

        
                                </td>
        
                                <td width="90px">
                                    <?php if($income->is_approved == true): ?>
                                        <?php if($income->approvable_type == 'App\Models\Pharmacist\Prescription'): ?>
                                            <a href="<?php echo e(route('rec.pres.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\LabModule\Experiment'): ?>
                                            <a href="<?php echo e(route('rec.expr.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription'): ?>
                                            <a href="<?php echo e(route('rec.surpre.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="approve('<?php echo e(route('approval.approve', $income->id)); ?>', event)">
                                        <i class="fa fa-check"></i> &nbsp;<?php echo e(__('global.approve')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="reject('<?php echo e(route('approval.reject', $income->id)); ?>', event)">
                                        <i class="fa fa-times"></i> &nbsp;<?php echo e(__('global.reject')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="<?php echo e($income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#'); ?>">
                                        <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                            <i class="flaticon-eye"></i> &nbsp;<?php echo e(__('global.view')); ?>

                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
        
                    <?php echo e($approvedPayments->appends(array_merge($_GET, ['tab' => 'approved']))->links()); ?>

                </div>
                <div class="tab-pane <?php echo e($tab == 'rejected' ? 'active show' : ''); ?>" id="rejected" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th><?php echo e(__('global.number')); ?></th>
                                <th><?php echo e(__('finance.incSection')); ?></th>
                                <th><?php echo e(__('reception.pat_name')); ?></th>
                                <th><?php echo e(__('finance.total_paid')); ?></th>
                                <th><?php echo e(__('reception.pat_regdate')); ?></th>
                                <th><?php echo e(__('admin.adm_state')); ?></th>
                                <th><?php echo e(__('reception.approval_date')); ?></th>
                                <th colspan="4"><?php echo e(__('global.operation')); ?></th>
                            </tr>
                        </thead>
                        <?php
                        ?>
                        <tbody>
                            <?php $__currentLoopData = $rejectedPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($income->type == 'refund'): ?>
                                <tr class="m-table__row--warning">
                            <?php elseif($income->type == 'payment'): ?>
                                <tr class="m-table__row--success">
                            <?php else: ?>
                                <tr>
                            <?php endif; ?> 
                            
                            
                                <td><?php echo e(($rejectedPayments->currentPage() == 0 ? 1 : $rejectedPayments->currentPage() - 1) * $rejectedPayments ->perPage() + $key + 1); ?>

                                </td>
                                <td><?php echo e(__('finance.'.strtolower(basename($income->approvable_type, '\\')))); ?></td>
                                <td><?php echo e($income->record_no); ?></td>
                                <td><?php echo e($income->amount); ?> <?php echo e($currency[$income->currency_id]); ?></td>
                                <td><?php echo e($income->created_at->diffForHumans()); ?></td>
                                <td>
                                    <?php if($income->is_approved == 1): ?>
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        <?php echo e(__('global.received')); ?>

                                    </span>
                                    <?php elseif(is_null($income->is_approved)): ?>
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        <?php echo e(__('global.pending')); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        <?php echo e(__('global.rejected')); ?>

                                    </span>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e($income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : ''); ?>

        
                                </td>
        
                                <td width="90px">
                                    <?php if($income->is_approved == true): ?>
                                        <?php if($income->approvable_type == 'App\Models\Pharmacist\Prescription'): ?>
                                            <a href="<?php echo e(route('rec.pres.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\LabModule\Experiment'): ?>
                                            <a href="<?php echo e(route('rec.expr.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription'): ?>
                                            <a href="<?php echo e(route('rec.surpre.print', $income->approvable_id)); ?>">
                                                <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                                    <i class="la la-print"></i> &nbsp;<?php echo e(__('global.print')); ?>

                                                </button>
                                            </a>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="approve('<?php echo e(route('approval.approve', $income->id)); ?>', event)">
                                        <i class="fa fa-check"></i> &nbsp;<?php echo e(__('global.approve')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?>" <?php echo e(!is_null($income->is_approved) ? 'disabled' : ''); ?> onclick="reject('<?php echo e(route('approval.reject', $income->id)); ?>', event)">
                                        <i class="fa fa-times"></i> &nbsp;<?php echo e(__('global.reject')); ?>

                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="<?php echo e($income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#'); ?>">
                                        <button class="btn btn-default" <?php echo e($income->is_approved === 0 ? 'disabled' :  ''); ?>>
                                            <i class="flaticon-eye"></i> &nbsp;<?php echo e(__('global.view')); ?>

                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
        
                    <?php echo e($rejectedPayments->appends(array_merge($_GET, ['tab' => 'rejected']))->links()); ?>

                </div>
            </div>

        </div>
        <?php endif; // Entrust::can ?>
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
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('global.rjt_title')); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo e(__('global.rjt_message')); ?></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" onclick="document.getElementById('form-delete').submit();">
                    <?php echo e(__('global.yes')); ?>

                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo e(__('global.no')); ?>

                </button>

            </div>
        </div>
    </div>
</div>

<form method="post" style="display:none" action="" id="form-approve">
    <?php echo e(csrf_field()); ?>

</form>

<div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('global.apr_title')); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo e(__('global.apr_message')); ?></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-brand" onclick="document.getElementById('form-approve').submit();">
                    <?php echo e(__('global.yes')); ?>

                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('global.no')); ?>

                </button>

            </div>
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
            minimumInputLength: 4,
            ajax: {
                url: "<?php echo e(route('approval.search')); ?>",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.record_no,
                                id: item.id
                            }
                        })
                    };
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
        });

        search.on("change", function(e) {
            var object = $(this).select2('data')[0];
            window.location.href = '<?php echo e(route("approval.index")); ?>' + '?tab=search&term=' + object.text;
        });
    });

    function reject(route, e) {
        e.preventDefault();
        $('#form-delete').attr('action', route);
        $('#m_modal_1').modal('show');
    }

    function approve(route, e) {
        e.preventDefault();
        $('#form-approve').attr('action', route);
        $('#m_modal_2').modal('show');
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\db\htdocs\hosys\resources\views/receptionist-module/approval/index.blade.php ENDPATH**/ ?>