@extends('layouts.app')


@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('reception.rec_modul')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.frst_page')}}</span>
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
        @permission('rec_apr_show')
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-md-4 order-2 order-xl-1">
                        <select name="search" id="quick-search" class="form-control">
                        </select>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        {{-- <div class="m-separator m-separator--dashed d-xl-none"></div> --}}
                        {{-- <a href="{{ route('din.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a> --}}
                    </div>
                </div>
            </div>
            <hr>
            @include('errors.alert')

            <ul class="nav nav-tabs mt-3" role="tablist">
                @if (!is_null($searches))
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'search' ? 'active show' : '' }}" data-toggle="tab" href="#search">
                            <h5>{{__('global.quickResult')}}</h5>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'all-approvales' ? 'active show' : '' }}" data-toggle="tab" href="#approvales">
                        <h5>{{__('global.allApprovales')}}</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'pending' ? 'active show' : '' }}" data-toggle="tab" href="#pending">
                        <h5>{{__('global.waitingAppr')}}</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'approved' ? 'active show' : '' }}" data-toggle="tab" href="#approved">
                        <h5>{{__('global.paidAppr')}}</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'rejected' ? 'active show' : '' }}" data-toggle="tab" href="#rejected">
                        <h5>{{__('global.rejectedAppr')}}</h5>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                
                @if (!is_null($searches))
                    <div class="tab-pane {{ $tab == 'search' ? 'active show' : '' }}" id="search" role="tabpanel">

                        <table class="table m-table m-table--head-separator-primary">
                            <thead class="table-inverse">
                                <tr>
                                    <th>{{__('global.number')}}</th>
                                    <th>{{__('finance.incSection')}}</th>
                                    <th>{{__('reception.pat_name')}}</th>
                                    <th>{{__('finance.total_paid')}}</th>
                                    <th>{{__('reception.pat_regdate')}}</th>
                                    <th>{{__('admin.adm_state')}}</th>
                                    <th>{{__('reception.approval_date')}}</th>
                                    <th colspan="4">{{__('global.operation')}}</th>
                                </tr>
                            </thead>
                            @php
                            if(app()->getLocale() == 'dr'){
                                setlocale(LC_TIME, 'fa_IR');
                                Carbon\Carbon::setLocale('fa');
                            $currency = \App\Models\FinanceModule\Currency::pluck('label_dr', 'id')->toArray();
                            }else{
                                $currency = \App\Models\FinanceModule\Currency::pluck('label_en', 'id')->toArray();
                            }
                            // dd($currency)
                            @endphp
                            <tbody>
                                @foreach($searches as $key => $income)
                                @if($income->type == 'refund')
                                    <tr class="m-table__row--warning">
                                @elseif ($income->type == 'payment')
                                    <tr class="m-table__row--success">
                                @else
                                    <tr>
                                @endif 
                                
                                {{-- <tr class="{{ $income->type == 'refund' ? 'm-table__row--warning': null }}"> --}}
                                    <td>{{ ($searches->currentPage() == 0 ? 1 :$searches->currentPage() - 1) * $searches ->perPage() + $key + 1}}
                                    </td>
                                    <td>{{ __('finance.'.strtolower(basename($income->approvable_type, '\\')))  }}</td>
                                    <td>{{ $income->record_no }}</td>
                                    <td>{{ $income->amount }} {{ $currency[$income->currency_id] }}</td>
                                    <td>{{ $income->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($income->is_approved == 1)
                                        <span class="m-badge m-badge--brand m-badge--wide">
                                            {{__('global.received')}}
                                        </span>
                                        @elseif(is_null($income->is_approved))
                                        <span class="m-badge m-badge--danger m-badge--wide">
                                            {{__('global.pending')}}
                                        </span>
                                        @else
                                        <span class="m-badge m-badge--dark m-badge--wide">
                                            {{__('global.rejected')}}
                                        </span>
                                        @endif
                                        {{-- $income->is_approved ? __('global.received') : __('global.pending') --}}
                                    </td>
                                    <td>
                                        {{ $income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : '' }}
            
                                    </td>
            
                                    <td width="90px">
                                        @if ($income->is_approved == true)
                                            @if($income->approvable_type == 'App\Models\Pharmacist\Prescription')
                                                <a href="{{ route('rec.pres.print', $income->approvable_id) }}">
                                                    <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                        <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                    </button>
                                                </a>
                                            @elseif($income->approvable_type == 'App\Models\LabModule\Experiment')
                                                <a href="{{ route('rec.expr.print', $income->approvable_id) }}">
                                                    <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                        <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                    </button>
                                                </a>
                                            @elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                                                <a href="{{ route('rec.surpre.print', $income->approvable_id) }}">
                                                    <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                        <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                    </button>
                                                </a>
                                            @endif
                                            
                                        @endif
                                    </td>
            
                                    <td width="90px">
                                        <button class="btn btn-primary {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="approve('{{ route('approval.approve', $income->id) }}', event)">
                                            <i class="fa fa-check"></i> &nbsp;{{ __('global.approve') }}
                                        </button>
                                    </td>
                                    <td width="90px">
                                        <button class="btn btn-danger {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="reject('{{ route('approval.reject', $income->id) }}', event)">
                                            <i class="fa fa-times"></i> &nbsp;{{ __('global.reject') }}
                                        </button>
                                    </td>
                                    <td width="90px">
                                        <a href="{{ $income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#' }}">
                                            <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                <i class="flaticon-eye"></i> &nbsp;{{ __('global.view') }}
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
            
                        {{ $searches->appends(array_merge($_GET, ['tab' => 'search']))->links() }}
                    </div>
                @endif
                
                <div class="tab-pane {{ $tab == 'all-approvales' ? 'active show' : '' }}" id="approvales" role="tabpanel">

                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('global.number')}}</th>
                                <th>{{__('finance.incSection')}}</th>
                                <th>{{__('reception.pat_name')}}</th>
                                <th>{{__('finance.total_paid')}}</th>
                                <th>{{__('reception.pat_regdate')}}</th>
                                <th>{{__('admin.adm_state')}}</th>
                                <th>{{__('reception.approval_date')}}</th>
                                <th colspan="4">{{__('global.operation')}}</th>
                            </tr>
                        </thead>
                        @php
                        if(app()->getLocale() == 'dr'){
                            setlocale(LC_TIME, 'fa_IR');
                            Carbon\Carbon::setLocale('fa');
                        $currency = \App\Models\FinanceModule\Currency::pluck('label_dr', 'id')->toArray();
                        }else{
                            $currency = \App\Models\FinanceModule\Currency::pluck('label_en', 'id')->toArray();
                        }
                        // dd($currency)
                        @endphp
                        <tbody>
                            @foreach($approvables as $key => $income)
                            @if($income->type == 'refund')
                                <tr class="m-table__row--warning">
                            @elseif ($income->type == 'payment')
                                <tr class="m-table__row--success">
                            @else
                                <tr>
                            @endif 
                            
                            {{-- <tr class="{{ $income->type == 'refund' ? 'm-table__row--warning': null }}"> --}}
                                <td>{{ ($approvables->currentPage() == 0 ? 1 :$approvables->currentPage() - 1) * $approvables ->perPage() + $key + 1}}
                                </td>
                                <td>{{ __('finance.'.strtolower(basename($income->approvable_type, '\\')))  }}</td>
                                <td>{{ $income->record_no }}</td>
                                <td>{{ $income->amount }} {{ $currency[$income->currency_id] }}</td>
                                <td>{{ $income->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($income->is_approved == 1)
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        {{__('global.received')}}
                                    </span>
                                    @elseif(is_null($income->is_approved))
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        {{__('global.pending')}}
                                    </span>
                                    @else
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        {{__('global.rejected')}}
                                    </span>
                                    @endif
                                    {{-- $income->is_approved ? __('global.received') : __('global.pending') --}}
                                </td>
                                <td>
                                    {{ $income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : '' }}
        
                                </td>
        
                                <td width="90px">
                                    @if ($income->is_approved == true)
                                        @if($income->approvable_type == 'App\Models\Pharmacist\Prescription')
                                            <a href="{{ route('rec.pres.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\LabModule\Experiment')
                                            <a href="{{ route('rec.expr.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                                            <a href="{{ route('rec.surpre.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @endif
                                        
                                    @endif
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="approve('{{ route('approval.approve', $income->id) }}', event)">
                                        <i class="fa fa-check"></i> &nbsp;{{ __('global.approve') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="reject('{{ route('approval.reject', $income->id) }}', event)">
                                        <i class="fa fa-times"></i> &nbsp;{{ __('global.reject') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="{{ $income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#' }}">
                                        <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                            <i class="flaticon-eye"></i> &nbsp;{{ __('global.view') }}
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $approvables->appends(array_merge($_GET, ['tab' => 'all-approvales']))->links() }}
                </div>
                <div class="tab-pane {{ $tab == 'pending' ? 'active show' : '' }}" id="pending" role="tabpanel">

                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('global.number')}}</th>
                                <th>{{__('finance.incSection')}}</th>
                                <th>{{__('reception.pat_name')}}</th>
                                <th>{{__('finance.total_paid')}}</th>
                                <th>{{__('reception.pat_regdate')}}</th>
                                <th>{{__('admin.adm_state')}}</th>
                                <th>{{__('reception.approval_date')}}</th>
                                <th colspan="4">{{__('global.operation')}}</th>
                            </tr>
                        </thead>
                        @php
                        @endphp
                        <tbody>
                            @foreach($pendingApprovales as $key => $income)
                            @if($income->type == 'refund')
                                <tr class="m-table__row--warning">
                            @elseif ($income->type == 'payment')
                                <tr class="m-table__row--success">
                            @else
                                <tr>
                            @endif 
                            
                            {{-- <tr class="{{ $income->type == 'refund' ? 'm-table__row--warning': null }}"> --}}
                                <td>{{ ($pendingApprovales->currentPage() == 0 ? 1 : $pendingApprovales->currentPage() - 1) * $pendingApprovales ->perPage() + $key + 1}}
                                </td>
                                <td>{{ __('finance.'.strtolower(basename($income->approvable_type, '\\')))  }}</td>
                                <td>{{ $income->record_no }}</td>
                                <td>{{ $income->amount }} {{ $currency[$income->currency_id] }}</td>
                                <td>{{ $income->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($income->is_approved == 1)
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        {{__('global.received')}}
                                    </span>
                                    @elseif(is_null($income->is_approved))
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        {{__('global.pending')}}
                                    </span>
                                    @else
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        {{__('global.rejected')}}
                                    </span>
                                    @endif
                                    {{-- $income->is_approved ? __('global.received') : __('global.pending') --}}
                                </td>
                                <td>
                                    {{ $income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : '' }}
        
                                </td>
        
                                <td width="90px">
                                    @if ($income->is_approved == true)
                                        @if($income->approvable_type == 'App\Models\Pharmacist\Prescription')
                                            <a href="{{ route('rec.pres.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\LabModule\Experiment')
                                            <a href="{{ route('rec.expr.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                                            <a href="{{ route('rec.surpre.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @endif
                                        
                                    @endif
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="approve('{{ route('approval.approve', $income->id) }}', event)">
                                        <i class="fa fa-check"></i> &nbsp;{{ __('global.approve') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="reject('{{ route('approval.reject', $income->id) }}', event)">
                                        <i class="fa fa-times"></i> &nbsp;{{ __('global.reject') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="{{ $income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#' }}">
                                        <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                            <i class="flaticon-eye"></i> &nbsp;{{ __('global.view') }}
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $pendingApprovales->appends(array_merge($_GET, ['tab' => 'pending']))->links() }}
                </div>
                <div class="tab-pane {{ $tab == 'approved' ? 'active show' : '' }}" id="approved" role="tabpanel">
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('global.number')}}</th>
                                <th>{{__('finance.incSection')}}</th>
                                <th>{{__('reception.pat_name')}}</th>
                                <th>{{__('finance.total_paid')}}</th>
                                <th>{{__('reception.pat_regdate')}}</th>
                                <th>{{__('admin.adm_state')}}</th>
                                <th>{{__('reception.approval_date')}}</th>
                                <th colspan="4">{{__('global.operation')}}</th>
                            </tr>
                        </thead>
                        @php
                        @endphp
                        <tbody>
                            @foreach($approvedPayments as $key => $income)
                            @if($income->type == 'refund')
                                <tr class="m-table__row--warning">
                            @elseif ($income->type == 'payment')
                                <tr class="m-table__row--success">
                            @else
                                <tr>
                            @endif 
                            
                            {{-- <tr class="{{ $income->type == 'refund' ? 'm-table__row--warning': null }}"> --}}
                                <td>{{ ($approvedPayments->currentPage() == 0 ? 1 : $approvedPayments->currentPage() - 1) * $approvedPayments ->perPage() + $key + 1}}
                                </td>
                                <td>{{ __('finance.'.strtolower(basename($income->approvable_type, '\\')))  }}</td>
                                <td>{{ $income->record_no }}</td>
                                <td>{{ $income->amount }} {{ $currency[$income->currency_id] }}</td>
                                <td>{{ $income->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($income->is_approved == 1)
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        {{__('global.received')}}
                                    </span>
                                    @elseif(is_null($income->is_approved))
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        {{__('global.pending')}}
                                    </span>
                                    @else
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        {{__('global.rejected')}}
                                    </span>
                                    @endif
                                    {{-- $income->is_approved ? __('global.received') : __('global.pending') --}}
                                </td>
                                <td>
                                    {{ $income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : '' }}
        
                                </td>
        
                                <td width="90px">
                                    @if ($income->is_approved == true)
                                        @if($income->approvable_type == 'App\Models\Pharmacist\Prescription')
                                            <a href="{{ route('rec.pres.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\LabModule\Experiment')
                                            <a href="{{ route('rec.expr.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                                            <a href="{{ route('rec.surpre.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @endif
                                        
                                    @endif
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="approve('{{ route('approval.approve', $income->id) }}', event)">
                                        <i class="fa fa-check"></i> &nbsp;{{ __('global.approve') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="reject('{{ route('approval.reject', $income->id) }}', event)">
                                        <i class="fa fa-times"></i> &nbsp;{{ __('global.reject') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="{{ $income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#' }}">
                                        <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                            <i class="flaticon-eye"></i> &nbsp;{{ __('global.view') }}
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $approvedPayments->appends(array_merge($_GET, ['tab' => 'approved']))->links() }}
                </div>
                <div class="tab-pane {{ $tab == 'rejected' ? 'active show' : '' }}" id="rejected" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('global.number')}}</th>
                                <th>{{__('finance.incSection')}}</th>
                                <th>{{__('reception.pat_name')}}</th>
                                <th>{{__('finance.total_paid')}}</th>
                                <th>{{__('reception.pat_regdate')}}</th>
                                <th>{{__('admin.adm_state')}}</th>
                                <th>{{__('reception.approval_date')}}</th>
                                <th colspan="4">{{__('global.operation')}}</th>
                            </tr>
                        </thead>
                        @php
                        @endphp
                        <tbody>
                            @foreach($rejectedPayments as $key => $income)
                            @if($income->type == 'refund')
                                <tr class="m-table__row--warning">
                            @elseif ($income->type == 'payment')
                                <tr class="m-table__row--success">
                            @else
                                <tr>
                            @endif 
                            
                            {{-- <tr class="{{ $income->type == 'refund' ? 'm-table__row--warning': null }}"> --}}
                                <td>{{ ($rejectedPayments->currentPage() == 0 ? 1 : $rejectedPayments->currentPage() - 1) * $rejectedPayments ->perPage() + $key + 1}}
                                </td>
                                <td>{{ __('finance.'.strtolower(basename($income->approvable_type, '\\')))  }}</td>
                                <td>{{ $income->record_no }}</td>
                                <td>{{ $income->amount }} {{ $currency[$income->currency_id] }}</td>
                                <td>{{ $income->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($income->is_approved == 1)
                                    <span class="m-badge m-badge--brand m-badge--wide">
                                        {{__('global.received')}}
                                    </span>
                                    @elseif(is_null($income->is_approved))
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        {{__('global.pending')}}
                                    </span>
                                    @else
                                    <span class="m-badge m-badge--dark m-badge--wide">
                                        {{__('global.rejected')}}
                                    </span>
                                    @endif
                                    {{-- $income->is_approved ? __('global.received') : __('global.pending') --}}
                                </td>
                                <td>
                                    {{ $income->approvedBy()->exists() ? __('global.on') . ' ' . $income->approved_date . ' ' . __('global.by') . ' ' .(app()->getLocale() == 'en' ? $income->approvedBy->name : $income->approvedBy->name_dr) . ' ' : '' }}
        
                                </td>
        
                                <td width="90px">
                                    @if ($income->is_approved == true)
                                        @if($income->approvable_type == 'App\Models\Pharmacist\Prescription')
                                            <a href="{{ route('rec.pres.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\LabModule\Experiment')
                                            <a href="{{ route('rec.expr.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @elseif($income->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                                            <a href="{{ route('rec.surpre.print', $income->approvable_id) }}">
                                                <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                                    <i class="la la-print"></i> &nbsp;{{__('global.print')}}
                                                </button>
                                            </a>
                                        @endif
                                        
                                    @endif
                                </td>
        
                                <td width="90px">
                                    <button class="btn btn-primary {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="approve('{{ route('approval.approve', $income->id) }}', event)">
                                        <i class="fa fa-check"></i> &nbsp;{{ __('global.approve') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <button class="btn btn-danger {{ !is_null($income->is_approved) ? 'disabled' : '' }}" {{ !is_null($income->is_approved) ? 'disabled' : '' }} onclick="reject('{{ route('approval.reject', $income->id) }}', event)">
                                        <i class="fa fa-times"></i> &nbsp;{{ __('global.reject') }}
                                    </button>
                                </td>
                                <td width="90px">
                                    <a href="{{ $income->is_approved !== 0 ? optional(optional($income->approvable)->profit)->url : '#' }}">
                                        <button class="btn btn-default" {{ $income->is_approved === 0 ? 'disabled' :  ''}}>
                                            <i class="flaticon-eye"></i> &nbsp;{{ __('global.view') }}
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $rejectedPayments->appends(array_merge($_GET, ['tab' => 'rejected']))->links() }}
                </div>
            </div>

        </div>
        @endpermission
    </div>
</div>

<form method="post" style="display:none" action="" id="form-delete">
    {{csrf_field()}}
    {{method_field('delete')}}
</form>

<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('global.rjt_title')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('global.rjt_message')}}</p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" onclick="document.getElementById('form-delete').submit();">
                    {{__('global.yes')}}
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal">{{__('global.no')}}
                </button>

            </div>
        </div>
    </div>
</div>

<form method="post" style="display:none" action="" id="form-approve">
    {{csrf_field()}}
</form>

<div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('global.apr_title')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('global.apr_message')}}</p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-brand" onclick="document.getElementById('form-approve').submit();">
                    {{__('global.yes')}}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('global.no')}}
                </button>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '{{__("global.search")}}',
            dir: '{{ app()->isLocale("en") ? "ltr" : "rtl" }}',
            minimumInputLength: 4,
            ajax: {
                url: "{{ route('approval.search') }}",
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
            window.location.href = '{{ route("approval.index") }}' + '?tab=search&term=' + object.text;
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

@endsection