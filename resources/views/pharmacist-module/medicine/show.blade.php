@extends('layouts.app')
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
                    <a href="{{route('medicine.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('global.gol_fpageMed')}}</span>
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('medicine.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        
                        <a href="{{ route('medicine.edit', $medicine->id) }}" class="btn btn-secondary">
                            <span>
                                <i class="la la-pencil"></i> <span>{{__('global.gol_edit')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="btn-group">
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('medicine.create') }}">
                                <span> <i class="la la-plus"></i> <span>{{ __('global.create') }}</span>
                                </span>
                            </a>
                            <button type="button" class="btn  btn-focus m-btn--air dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">
                                    {{ __('global.gol_more_options') }}
                                </span>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(80px, 40px, 0px);">
                                <a class="dropdown-item" href="{{ route('medicine.create') .'?multiple' }}">
                                    {{ __('global.gol_create_multiple') }}
                                </a>
                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            @include('errors.alert')
            @include('errors.validation-errors')
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title"> {{__('pharmacist.med_info')}}</h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('pharmacist.med_name')}} </label>
                                    <p><strong>{{ $medicine->name }}</strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('pharmacist.med_company')}}</label>
                                    <p><strong>{{ $medicine->company }}</strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('pharmacist.med_milligram')}}</label>
                                    <p><strong>{{ $medicine->milligram }}</strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> {{__('pharmacist.med_type')}} </label>
                                    <p><strong>
                                            {{ app()->isLocale('en') ? $medicine->type->label_en : $medicine->type->label_dr  }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('pharmacist.med_unit')}}</label>
                                    <p><strong>
                                        {{ app()->isLocale('en') ? $medicine->unit->label_en : $medicine->unit->label_dr }}
                                    </strong></p>
                                </div>

                            </div>

                        </div>
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title">{{__('pharmacist.med_excist')}}</h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> {{__('pharmacist.med_excist')}} </label>
                                    <p><strong>
                                        {{ $medicine->store->quantity }}
                                        {{ app()->isLocale('en') ? $medicine->unit->label_en : $medicine->unit->label_dr }}
                                    </strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label"> {{__('pharmacist.med_price')}}</label>
                                    <p><strong>
                                        {{ $medicine->store->unit_price }}
                                        {{ app()->getLocale() == 'en' ? $medicine->store->currency->label_en : $medicine->store->currency->label_dr }}
                                    </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection