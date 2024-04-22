@extends('layouts.app')


@section('sidebar')
@include('pharmacist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('pharmacist.med_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"> {{__('global.gol_fpage')}}</span>
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
                    <div class="col-xl-4 col-md-4 order-2 order-xl-1">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                    </div>
                    <div class="col-xl-8 col-md-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('prescription.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="{{ route('prescription.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{ __('global.create') }}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>

            <ul class="nav nav-tabs mt-3" role="tablist">
                @if (!is_null($searches))
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'search' ? 'active show' : '' }}" data-toggle="tab" href="#search">
                            <h5>{{__('global.quickResult')}}</h5>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'all-pres' ? 'active show' : '' }}" data-toggle="tab" href="#approvales">
                        <h5>{{__('global.allPres')}}</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'pending' ? 'active show' : '' }}" data-toggle="tab" href="#pending">
                        <h5>{{__('global.waitingAppr')}}</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'surpres' ? 'active show' : '' }}" data-toggle="tab" href="#surpres">
                        <h5>{{__('global.laterPres')}}</h5>
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
                                    <th>{{__('pharmacist.med_number')}}</th>
                                    <th> {{__('reception.vis_patent')}}</th>
                                    <th> {{__('reception.vis_record')}}</th>
                                    <th> {{__('global.issue_date')}}</th>
                                    {{-- <th> {{__('reception.vis_doctors')}}</th> --}}
                                    <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                    <th> {{__('pharmacist.med_totalPrice')}}</th>
                                    <th> {{__('admin.adm_state')}}</th>
                                    <th>{{__('global.approval')}}</th>
                                    <th>{{__('pharmacist.med_operation')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $class = '\\App\\Models\\Pharmacist\\SurgeryPrescription';
                                @endphp
                                @foreach($searches as $key => $pres)
                                <tr class="{{ $pres instanceof $class ? 'm-table__row--warning' : '' }}">
                                    <td>{{ ($searches->currentPage() == 0 ? 1 :$searches->currentPage() - 1) * $searches ->perPage() + $key + 1}}
                                    </td>
                                    <td>{{ $pres->patient->name  }}</td>
                                    <td>{{ $pres->patient->record_no }}</td>
                                    <td>{{ $pres->date }}
                                        {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                    {{-- <td>{{ optional($pres->doctor)->name }}</td> --}}
                                    <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                    <td>
                                        {{ $pres->profit->totalAmount }}
                                        {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                    </td>
                                    <td>
                                        @php
                                            $status = optional($pres->approve)->map(function ($item, $key) {
                                                if ($item->is_approved === 1)
                                                    return '<span class="text-success la la-check"></span>';
            
                                                if ($item->is_approved === null)
                                                    return '<span class="text-info la la-minus"></span>';
            
                                                if ($item->is_approved === 0)
                                                    return '<span class="text-danger la la-close"></span>';
                                                
                                            });
                                            
                                            echo implode(' ', optional($status)->toArray())
                                        @endphp
                                    </td>
                                    <td>
                                        <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                            {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                        </span>
                                    </td>
                                    @if ($pres instanceof $class)
                                        <td>
                                            <a href="{{ route('surpres.show', [$pres->id]) }}">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('surpres.edit', $pres->id) }}">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                        </td>
                                        
                                    @else
                                        <td>
                                            <a href="{{ route('prescription.show', [$pres->id]) }}">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('prescription.edit', $pres->id) }}">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                        </td>
                                        
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $searches->appends(array_merge($_GET, ['tab' => 'search']))->links() }}
                    </div>
                @endif
                
                <div class="tab-pane {{ $tab == 'all-pres' ? 'active show' : '' }}" id="approvales" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('pharmacist.med_number')}}</th>
                                <th> {{__('reception.vis_patent')}}</th>
                                <th> {{__('reception.vis_record')}}</th>
                                <th> {{__('global.issue_date')}}</th>
                                {{-- <th> {{__('reception.vis_doctors')}}</th> --}}
                                <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                <th> {{__('pharmacist.med_totalPrice')}}</th>
                                <th> {{__('admin.adm_state')}}</th>
                                <th>{{__('global.approval')}}</th>
                                <th>{{__('pharmacist.med_operation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $class = '\\App\\Models\\Pharmacist\\SurgeryPrescription';
                            @endphp
                            @foreach($prescriptions as $key => $pres)
                            <tr class="{{ $pres instanceof $class ? 'm-table__row--warning' : '' }}">
                                <td>{{ ($prescriptions->currentPage() == 0 ? 1 :$prescriptions->currentPage() - 1) * $prescriptions ->perPage() + $key + 1}}
                                </td>
                                <td>{{ $pres->patient->name  }}</td>
                                <td>{{ $pres->patient->record_no }}</td>
                                <td>{{ $pres->date }}
                                    {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                {{-- <td>{{ optional($pres->doctor)->name }}</td> --}}
                                <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                <td>
                                    {{ $pres->profit->totalAmount }}
                                    {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                </td>
                                <td>
                                    @php
                                        $status = optional($pres->approve)->map(function ($item, $key) {
                                            if ($item->is_approved === 1)
                                                return '<span class="text-success la la-check"></span>';
        
                                            if ($item->is_approved === null)
                                                return '<span class="text-info la la-minus"></span>';
        
                                            if ($item->is_approved === 0)
                                                return '<span class="text-danger la la-close"></span>';
                                            
                                        });
                                        
                                        echo implode(' ', optional($status)->toArray())
                                    @endphp
                                </td>
                                <td>
                                    <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                        {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                    </span>
                                </td>
                                    @if ($pres instanceof $class)
                                        <td>
                                            <a href="{{ route('surpres.show', [$pres->id]) }}">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('surpres.edit', $pres->id) }}">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                        </td>
                                        
                                    @else
                                        <td>
                                            <a href="{{ route('prescription.show', [$pres->id]) }}">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('prescription.edit', $pres->id) }}">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                        </td>
                                        
                                    @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $prescriptions->appends(array_merge($_GET, ['tab' => 'all-pres']))->links() }}
                </div>
                <div class="tab-pane {{ $tab == 'pending' ? 'active show' : '' }}" id="pending" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('pharmacist.med_number')}}</th>
                                <th> {{__('reception.vis_patent')}}</th>
                                <th> {{__('reception.vis_record')}}</th>
                                <th> {{__('global.issue_date')}}</th>
                                <th> {{__('reception.vis_doctors')}}</th>
                                <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                <th> {{__('pharmacist.med_totalPrice')}}</th>
                                <th> {{__('admin.adm_state')}}</th>
                                <th>{{__('global.approval')}}</th>
                                <th>{{__('pharmacist.med_operation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPres as $key => $pres)
                            <tr>
                                <td>{{ ($pendingPres->currentPage() == 0 ? 1 :$pendingPres->currentPage() - 1) * $pendingPres ->perPage() + $key + 1}}
                                </td>
                                <td>{{ $pres->patient->name  }}</td>
                                <td>{{ $pres->patient->record_no }}</td>
                                <td>{{ $pres->date }}
                                    {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                <td>{{ $pres->doctor->name }}</td>
                                <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                <td>
                                    {{ $pres->profit->totalAmount }}
                                    {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                </td>
                                <td>
                                    @php
                                        $status = optional($pres->approve)->map(function ($item, $key) {
                                            if ($item->is_approved === 1)
                                                return '<span class="text-success la la-check"></span>';
        
                                            if ($item->is_approved === null)
                                                return '<span class="text-info la la-minus"></span>';
        
                                            if ($item->is_approved === 0)
                                                return '<span class="text-danger la la-close"></span>';
                                            
                                        });
                                        
                                        echo implode(' ', optional($status)->toArray())
                                    @endphp
                                </td>
                                <td>
                                    <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                        {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('prescription.show', [$pres->id]) }}">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('prescription.edit', $pres->id) }}">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $pendingPres->appends(array_merge($_GET, ['tab' => 'pending']))->links() }}
                </div>

                <div class="tab-pane {{ $tab == 'surpres' ? 'active show' : '' }}" id="surpres" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('pharmacist.med_number')}}</th>
                                <th> {{__('reception.vis_patent')}}</th>
                                <th> {{__('reception.vis_record')}}</th>
                                <th> {{__('global.issue_date')}}</th>
                                <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                <th> {{__('pharmacist.med_totalPrice')}}</th>
                                <th> {{__('admin.adm_state')}}</th>
                                <th>{{__('global.approval')}}</th>
                                <th>{{__('pharmacist.med_operation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surpreses as $key => $pres)
                            <tr>
                                <td>{{ ($surpreses->currentPage() == 0 ? 1 :$surpreses->currentPage() - 1) * $surpreses ->perPage() + $key + 1}}
                                </td>
                                <td>{{ $pres->patient->name  }}</td>
                                <td>{{ $pres->patient->record_no }}</td>
                                <td>{{ $pres->date }}
                                    {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                <td>
                                    {{ $pres->profit->totalAmount }}
                                    {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                </td>
                                <td>
                                    @php
                                        $status = optional($pres->approve)->map(function ($item, $key) {
                                            if ($item->is_approved === 1)
                                                return '<span class="text-success la la-check"></span>';
        
                                            if ($item->is_approved === null)
                                                return '<span class="text-info la la-minus"></span>';
        
                                            if ($item->is_approved === 0)
                                                return '<span class="text-danger la la-close"></span>';
                                            
                                        });
                                        
                                        echo implode(' ', optional($status)->toArray())
                                    @endphp
                                </td>
                                <td>
                                    <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                        {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('surpres.show', [$pres->id]) }}">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('surpres.edit', $pres->id) }}">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $surpreses->appends(array_merge($_GET, ['tab' => 'surpres']))->links() }}

                </div>
                <div class="tab-pane {{ $tab == 'approved' ? 'active show' : '' }}" id="approved" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('pharmacist.med_number')}}</th>
                                <th> {{__('reception.vis_patent')}}</th>
                                <th> {{__('reception.vis_record')}}</th>
                                <th> {{__('global.issue_date')}}</th>
                                <th> {{__('reception.vis_doctors')}}</th>
                                <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                <th> {{__('pharmacist.med_totalPrice')}}</th>
                                <th> {{__('admin.adm_state')}}</th>
                                <th>{{__('global.approval')}}</th>
                                <th>{{__('pharmacist.med_operation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paidPres as $key => $pres)
                            <tr>
                                <td>{{ ($paidPres->currentPage() == 0 ? 1 :$paidPres->currentPage() - 1) * $paidPres ->perPage() + $key + 1}}
                                </td>
                                <td>{{ $pres->patient->name  }}</td>
                                <td>{{ $pres->patient->record_no }}</td>
                                <td>{{ $pres->date }}
                                    {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                <td>{{ $pres->doctor->name }}</td>
                                <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                <td>
                                    {{ $pres->profit->totalAmount }}
                                    {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                </td>
                                <td>
                                    @php
                                        $status = optional($pres->approve)->map(function ($item, $key) {
                                            if ($item->is_approved === 1)
                                                return '<span class="text-success la la-check"></span>';
        
                                            if ($item->is_approved === null)
                                                return '<span class="text-info la la-minus"></span>';
        
                                            if ($item->is_approved === 0)
                                                return '<span class="text-danger la la-close"></span>';
                                            
                                        });
                                        
                                        echo implode(' ', optional($status)->toArray())
                                    @endphp
                                </td>
                                <td>
                                    <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                        {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('prescription.show', [$pres->id]) }}">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('prescription.edit', $pres->id) }}">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $paidPres->appends(array_merge($_GET, ['tab' => 'approved']))->links() }}
                </div>
                <div class="tab-pane {{ $tab == 'rejected' ? 'active show' : '' }}" id="rejected" role="tabpanel">
                    
                    <table class="table m-table m-table--head-separator-primary">
                        <thead class="table-inverse">
                            <tr>
                                <th>{{__('pharmacist.med_number')}}</th>
                                <th> {{__('reception.vis_patent')}}</th>
                                <th> {{__('reception.vis_record')}}</th>
                                <th> {{__('global.issue_date')}}</th>
                                <th> {{__('reception.vis_doctors')}}</th>
                                <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                <th> {{__('pharmacist.med_totalPrice')}}</th>
                                <th> {{__('admin.adm_state')}}</th>
                                <th>{{__('global.approval')}}</th>
                                <th>{{__('pharmacist.med_operation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedPres as $key => $pres)
                            <tr>
                                <td>{{ ($rejectedPres->currentPage() == 0 ? 1 :$rejectedPres->currentPage() - 1) * $rejectedPres ->perPage() + $key + 1}}
                                </td>
                                <td>{{ $pres->patient->name  }}</td>
                                <td>{{ $pres->patient->record_no }}</td>
                                <td>{{ $pres->date }}
                                    {{-- app()->getLocale() == 'en' ? $pres->type->label_en : $pres->type->label_dr --}}</td>
                                <td>{{ $pres->doctor->name }}</td>
                                <td>{{ $pres->medicines_count }} {{ __('pharmacist.pres_items') }}</td>
                                <td>
                                    {{ $pres->profit->totalAmount }}
                                    {{ app()->getLocale() == 'en' ? $pres->profit->currency->label_en : $pres->profit->currency->label_dr }}
                                </td>
                                <td>
                                    @php
                                        $status = optional($pres->approve)->map(function ($item, $key) {
                                            if ($item->is_approved === 1)
                                                return '<span class="text-success la la-check"></span>';
        
                                            if ($item->is_approved === null)
                                                return '<span class="text-info la la-minus"></span>';
        
                                            if ($item->is_approved === 0)
                                                return '<span class="text-danger la la-close"></span>';
                                            
                                        });
                                        
                                        echo implode(' ', optional($status)->toArray())
                                    @endphp
                                </td>
                                <td>
                                    <span class="m-badge {{$pres->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                        {{ $pres->is_approved ? __('global.received') : __('global.pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('prescription.show', [$pres->id]) }}">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('prescription.edit', $pres->id) }}">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{ $rejectedPres->appends(array_merge($_GET, ['tab' => 'rejected']))->links() }}
                </div>
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
            minimumInputLength: 5,
            ajax: {
                url: "{{ route('patient.search') }}",
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
            window.location.href = '{{ route("prescription.index") }}' + '?tab=search&term=' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><i class='la la-user'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'> {{ __('reception.pat_age') }} : " + repo.age + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''><span class='la la-phone'> :<small>" + repo.phone + "</small></div></span>" +
            "</div>" +
            "";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
@endsection

