@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection


@section('content')
<div class="m-subheader">
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
                    <a href=" {{ route('visit.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.vis_pat_visit')}}</span>
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
    {{-- check for print logs --}}
    @php
        $printLogs = \App\PrintLog::with(['user:id,name_dr'])
                                    ->where('printable_id', $visit->id)
                                    ->where('printable_type', \App\Models\Receptionist\Visit::class)
                                    ->get();
    @endphp

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">

                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('visit.search') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>

                        @php
                            $userPrintedLogCounter = $printLogs->where('printed_user', auth()->id());
                        @endphp

                        @if (auth()->user()->can('print_again') || $userPrintedLogCounter->count() <= 1)
                            <a href="{{ route('visit.print', [$visit->id]) }}" class="btn btn-secondary">
                                <span> <i class="la la-print"></i> <span>{{__('global.print')}}</span> </span> </a>
                        @endif

                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('visit.edit', [$visit->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span>{{__('profile.edit')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('visit.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            @include('errors.alert')
            @include('errors.validation-errors')
            <div class="row">
                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#activities" data-toggle="tab" class="nav-link active">{{__('reception.vis_info')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link">{{__('reception.pat_info')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#modules" data-toggle="tab" class="nav-link">{{__('reception.docy_info')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#prescription" data-toggle="tab" class="nav-link">{{__('pharmacist.side_prescription')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#experiment" data-toggle="tab" class="nav-link">{{__('lab.lab_exp')}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#print-log" data-toggle="tab" class="nav-link text-danger">{{__('global.printLog')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="activities">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('reception.vis_fullInfo')}}</h3>
                            </div>
                            <div class="row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.vis_cashier')}}</u></label>
                                        <p><strong>{{ $visit->cashier->email }}
                                                "{{ $visit->cashier->name_dr }}"</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('profile.user_regdate')}}</u></label>
                                        @php
                                        if(app()->getLocale() == 'dr'){
                                        setlocale(LC_TIME, 'fa_IR');
                                        Carbon\Carbon::setLocale('fa');
                                        }
                                        @endphp
                                        <p><strong>
                                                {{ $visit->created_at ? $visit->created_at->format('Y-m-d h:m A') : '' }}
                                                <br>
                                                "{{ $visit->created_at ? $visit->created_at->diffForHumans() : ''}}"
                                            </strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.pay_cashier')}}</u></label>
                                        <p><strong>{{ $visit->profit->recipient }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.docy_Fvalue')}}</u></label>
                                        <p><strong>{{ $visit->profit->amount }}
                                                {{ $visit->profit->currency->label_dr }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.pay_tax')}}</u></label>
                                        <p><strong>{{ $visit->profit->taxes }}
                                                {{ $visit->profit->currency->label_dr }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.pay_amount')}}</u></label>
                                        <p><strong>{{ $visit->profit->totalAmount }}
                                                {{ $visit->profit->currency->label_dr }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.pay_discount')}}</u></label>
                                        <p><strong>{{ $visit->discount ? $visit->discount ."%" : __('global.gol_no') }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.pay_cardNum')}}</u></label>
                                        <p><strong>{{ $visit->membership_id }}</strong></p>
                                    </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('reception.pat_fullInfo')}}</h3>
                            </div>
                            <div class="row">
                                <!-- <div class="row"> -->
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.pat_name')}}</u></label>
                                    <p><strong>{{ $visit->patient->name }}</strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.pat_age')}}</u></label>
                                    <p><strong>{{ $visit->patient->age }}</strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.sex')}}</u></label>
                                    <p><strong>{{ __("reception.{$visit->patient->sex}") }}</strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.pat_record')}}</u></label>
                                    <p><strong>{{ $visit->patient->record_no }}</strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.pat_phone')}}</u></label>
                                    <p><strong>{{ $visit->patient->phone_no }} </strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('reception.vis_address')}}</u></label>
                                    <p><strong>{{ $visit->patient->address }} </strong></p>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('profile.user_regdate')}}</u></label>
                                    <p><strong>{{ $visit->patient->created_at ? $visit->patient->created_at->format('Y-m-d h:m A') : '' }}</strong>
                                    </p>
                                </div>
                                <div class="col-lg-8 m-form__group-sub">
                                    <label class="form-control-label"><u>{{__('profile.user_registrant')}}</u></label>
                                    <p><strong>{{ $visit->patient->registrar->name }}->
                                            {{ $visit->patient->registrar->email }}</strong>
                                    </p>
                                </div>
                            </div>
                            <!--/row-->
                        </div>

                        <div class="tab-pane" id="modules">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('reception.docy_Info')}}</h3>
                            </div>
                            <div class="row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> {{__('reception.docy_name')}} </u></label>
                                        <p><strong>{{ $visit->doctor->first_name }}
                                                "{{ $visit->doctor->last_name }}"</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> {{__('reception.docy_email')}}
                                            </u></label>
                                        <p><strong>{{ $visit->doctor->email }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> {{__('reception.docy_specialze')}}
                                            </u></label>
                                        <p><strong>{{ $visit->doctor->specialist }} </strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u>{{__('reception.docy_fees')}}</u></label>
                                        <p><strong>{{ $visit->doctor->visit_fee }}
                                                {{ $visit->doctor->currency->label_dr }}</strong></p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> {{__('profile.user_registrant')}}
                                            </u></label>
                                        <p><strong>{{ $visit->doctor->registrar->name }}->
                                                {{ $visit->doctor->registrar->email }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><u> {{__('profile.user_regdate')}}</u></label>
                                        <p><strong>{{ $visit->doctor->created_at }}</strong>
                                        </p>
                                    </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="prescription">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('pharmacist.pre_presInfo')}}</h3>
                            </div>
                            @foreach($visit->patient->prescriptions as $key => $prescription)

                            <div class="row form-group m-form__group ">
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label">{{__('pharmacist.pre_issueDate')}} </label>
                                    <p><strong>{{ $prescription->date }}</strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label">{{__('pharmacist.med_register')}}</label>
                                    <p><strong>{{ app()->getLocale() == 'en' ? $prescription->registrar->name : $prescription->registrar->name_dr }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> {{__('global.operation')}}</label>
                                    <p><strong>
                                            {{ $prescription->profit->totalAmount }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_totalPayment')}}</label>
                                    <p>
                                        <a href="{{route('prescription.show', [$prescription->id])}}"><strong>{{ __('global.view') }}</strong></a>
                                    </p>
                                </div>
                            </div>

                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> {{__('pharmacist.med_number')}}</th>
                                        <th> {{__('pharmacist.med_name')}}</th>
                                        <th> {{__('pharmacist.med_type')}}</th>
                                        <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                        <th> {{__('pharmacist.med_price')}}</th>
                                        <th> {{__('pharmacist.med_totalPrice')}}</th>
                                        <th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prescription->medicines as $key => $medicine)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $medicine->name  }} ({{ $medicine->milligram }})</td>
                                        <td>{{ app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr }}
                                        </td>
                                        <td>
                                            {{ $medicine->pivot->quantity }}
                                            {{ app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr }}
                                        </td>
                                        <td>
                                            {{ $medicine->pivot->unit_price }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </td>
                                        <td>
                                            {{ ($medicine->pivot->quantity * $medicine->pivot->unit_price) }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            @endforeach
                        </div>

                        <div class="tab-pane" id="experiment">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('lab.lab_expInf')}}</h3>
                            </div>
                            @foreach($visit->patient->experiments as $key => $experiment)

                            <div class="row form-group m-form__group ">
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label">{{__('reception.pat_record')}} </label>
                                    <p><strong>{{ $experiment->record_no }}</strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label">{{__('pharmacist.med_register')}}</label>
                                    <p><strong>{{ app()->getLocale() == 'en' ? $experiment->registrar->name : $experiment->registrar->name_dr }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_totalPayment')}}</label>
                                    <p><strong>
                                            {{ $experiment->profit->totalAmount }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_totalPayment')}}</label>
                                    <p>
                                        <a href="{{route('experiment.show', [$experiment->id])}}"><strong>{{ __('global.view') }}</strong></a>
                                    </p>
                                </div>
                            </div>

                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> {{__('pharmacist.med_number')}}</th>
                                        <th> {{__('lab.lab_experiment')}}</th>
                                        <th> {{__('lab.lab_expExperimentor')}}</th>
                                        <th> {{__('pharmacist.med_totalPrice')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($experiment->tests as $key => $test)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $test->name  }}</td>
                                        <td>{{ $test->pivot->experimentor }}</td>
                                        <td>
                                            {{ $test->pivot->price }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            @endforeach
                        </div>

                        <div class="tab-pane" id="print-log">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">{{__('global.printLog')}}</h3>
                            </div>
                            
                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th> {{__('pharmacist.med_number')}}</th>
                                        <th> {{__('admin.usr_name')}}</th>
                                        <th> {{__('global.date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($printLogs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ optional($log->user)->name_dr  }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 order-lg-1 text-center">
                    <img src="{{ file_exists($visit->patient->photo) ? asset($visit->patient->photo) : url('assets/app/media/img/users/user4.jpg') }}" class="mx-auto img-fluid img-circle d-block" alt="avatar">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
{{-- <script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script> --}}
@endsection

@section('scripts')
@endsection