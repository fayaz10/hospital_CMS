@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

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
                    <a href="{{ route('patient.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.pat_Fpage')}}</span>
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
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('patient.invoice', [$patient->id]) }}" class="btn btn-secondary">
                            <span> <i class="flaticon-list-3"></i> <span>{{__('global.invoice')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('patient.edit', [$patient->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span>{{__('profile.edit')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('patient.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}
                                    </span> </span> </a> <div class="m-separator m-separator--dashed d-xl-none">
                    </div>
                </div>
            </div>
        </div>
        @include('errors.alert')
        @include('errors.validation-errors')
        <div class="row">
            <div class="col-lg-9 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#" data-target="#profile" data-toggle="tab" class="nav-link active">{{__('reception.pat_info')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#activities" data-toggle="tab" class="nav-link">{{__('reception.vis_info')}}</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" data-target="#prescription" data-toggle="tab" class="nav-link">{{__('pharmacist.side_prescription')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#experiment" data-toggle="tab" class="nav-link">{{__('lab.lab_exp')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#emergency" data-toggle="tab" class="nav-link">{{__('global.emergency')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-target="#din" data-toggle="tab" class="nav-link">{{__('finance.sideDiverseIncome')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">{{__('reception.pat_fullInfo')}}</h3>
                        </div>
                        <div class="row">
                            <!-- <div class="row"> -->
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.pat_name')}}</u></label>
                                <p><strong>{{ $patient->name }}</strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.pat_age')}}</u></label>
                                <p><strong>{{ $patient->age }}</strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.sex')}}</u></label>
                                <p><strong>{{ __("reception.{$patient->sex}") }}</strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.pat_record')}}</u></label>
                                <p><strong>{{ $patient->record_no }}</strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.pat_phone')}}</u></label>
                                <p><strong>{{ $patient->phone_no }} </strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('reception.vis_address')}}</u></label>
                                <p><strong>{{ $patient->address }} </strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('profile.user_regdate')}}</u></label>
                                <p><strong>{{ $patient->created_at ? $patient->created_at->format('Y-m-d h:m A') : '' }}</strong>
                                </p>
                            </div>
                            <div class="col-lg-8 m-form__group-sub">
                                <label class="form-control-label"><u>{{__('profile.user_registrant')}}</u></label>
                                <p><strong>{{ $patient->registrar->name }}->
                                        {{ $patient->registrar->email }}</strong>
                                </p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>

                    <div class="tab-pane" id="activities">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">{{__('reception.patientLastVisits')}}</h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            @foreach($patient->visits as $key => $visit)
                            <a href="{{ route('visit.show', [$visit->id]) }}" class="list-group-item list-group-item-action">
                                {{ $key + 1 . '. ' . $visit->created_at->format('Y-m-d') . ' ' . __('global.at') . ' ' .$visit->created_at->format('g:i A') }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane" id="prescription">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">{{__('pharmacist.pre_presInfo')}}</h3>
                        </div>
                        @foreach($patient->prescriptions as $key => $prescription)

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
                        @foreach($patient->experiments as $key => $experiment)

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

                    <div class="tab-pane" id="emergency">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">{{__('global.emrLatestPayments')}}</h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            @foreach($patient->emergencies as $key => $emergency)
                            <a href="{{ route('emergency.show', [$emergency->id]) }}" class="list-group-item list-group-item-action">
                                {{$key + 1 . '. ' . __('global.reason')}}: {{ $emergency->reason }}
                                <br>
                                {{ optional($emergency->created_at)->format('Y-m-d') . ' ' . __('global.at') . ' ' . optional($emergency->created_at)->format('g:i A') }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane" id="din">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">{{__('finance.sideDiverseIncome')}}</h3>
                        </div>
                        <div class="list-group" style="margin-top: 15px">
                            @foreach($patient->din as $key => $din)
                            <a href="{{ route('din.show', [$din->id]) }}" class="list-group-item list-group-item-action">
                                {{$key + 1 . '. ' . __('finance.dSubject')}}: {{ $din->subject }}
                                <br>
                                {{ optional($din->created_at)->format('Y-m-d') . ' ' . __('global.at') . ' ' . optional($din->created_at)->format('g:i A') }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 order-lg-1 text-center">
                <img src="{{ file_exists($patient->photo) ? asset($patient->photo) : url('assets/app/media/img/users/user4.jpg') }}" class="mx-auto img-fluid img-thumbnail img-circle d-block" alt="avatar">
                <p>{{app()->isLocale('dr') ? 'عکس مریض': 'Patient Photo'}}</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection