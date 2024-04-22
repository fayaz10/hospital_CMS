@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

@section('sidebar')
@include('pharmacist-module.partials.sidebar')
@endsection


@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> {{__('pharmacist.med_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href=" {{route('medicine.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('global.gol_fpageMed')}}</span>
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-progress">

                <!-- here can place a progress bar-->
            </div>
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="la la-user"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('pharmacist.med_AddnewMed')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('medicine.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{__('global.gol_save2')}}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('medicine.store') }}" id="save-form" enctype="multipart/form-data" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"> {{__('pharmacist.med_newMed')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"><i class="text-danger">*</i> {{__('pharmacist.med_name')}}</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"><i class="text-danger">*</i> {{__('pharmacist.med_milligram')}}</label>
                                        <input type="number" value="{{ old('milligram') }}" name="milligram" required class="form-control m-input" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"><i class="text-danger">*</i> {{__('pharmacist.med_company')}}</label>
                                        <input type="text" value="{{ old('company') }}" name="company" required class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <span class="text-danger">* </span> {{__('pharmacist.med_type')}} </label>
                                        <select class="form-control m-input" name="type_id">
                                            @foreach(\App\Models\Pharmacist\MedicineType::all() as $type)
                                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                                {{ app()->isLocale('en') ? $type->label_en : $type->label_dr }} ({{ $type->name }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"><i class="text-danger">*</i> {{__('pharmacist.med_unit')}}</label>
                                        <select class="form-control m-input" name="unit_id">
                                            @foreach(\App\Models\Pharmacist\Unit::all() as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}> {{ app()->isLocale('en') ? $unit->label_en : $unit->label_dr }} ({{ $unit->name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> {{__('تاریخ انقضا')}}</label>
                                        <input type="date" required value="{{ old('expire_date', date('Y-m-d')) }}" name="expire_date" required class="form-control m-input" placeholder="">
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"> {{__('pharmacist.med_excistNow')}}</h3>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label">{{__('pharmacist.med_excistNow')}}</label>
                                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label">{{__('pharmacist.med_price')}}</label>
                                        <input type="number" name="unit_price" value="{{ old('unit_price') }}" class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label">
                                            {{__('reception.docy_currency')}}
                                        </label>
                                        <select class="form-control m-input" name="currency_id">
                                            @foreach(\App\Models\FinanceModule\Currency::all() as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->label_dr }} ({{ $type->symbol }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
<!-- <script src="{{asset('js/select2.min.js')}}"></script> -->
@endsection

@section('scripts')
<!-- <script src="{{asset('js/select2.min.js')}}"></script> -->

<script type="text/javascript">
    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');
        form.validate();

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });

        if (form.valid())
            form.submit();
    });
</script>
@endsection