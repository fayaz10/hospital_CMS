@extends('layouts.app')


@section('sidebar')
@include('finance-module.partials.sidebar')
@endsection


@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('finance.finance-module')}}</h3>
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('expense.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">

                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title"> {{__('finance.expenseInfo')}}</h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('finance.incSection')}} </label>
                                    <p><strong>{{ __('finance.'.strtolower(basename($expense->spendable_type, '\\'))) }}</strong>
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('finance.paymentDate')}}</label>
                                    <p><strong>{{ $expense->payment_date }}</strong></p>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-control-label">{{__('lab.lab_expCreatedAt')}}</label>
                                    <p><strong>{{ $expense->created_at->format('Y-m-d g:i A') }}</strong></p>
                                </div>
                            </div>
                            <div class="row form-group m-form__group ">
                                <div class="col-lg-4">
                                    <label class="form-control-label"> {{__('finance.amount')}} </label>
                                    <p><strong>
                                            {{ $expense->amount }}
                                            {{ app()->isLocale('en') ? $expense->currency->label_en : $expense->currency->label_dr  }}
                                        </strong></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-control-label"> {{__('pharmacist.med_register')}} </label>
                                        <p><strong>
                                            {{ app()->isLocale('en') ? $expense->registrar->name : $expense->registrar->name_dr  }}

                                        </strong></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-control-label">{{__('pharmacist.med_payment')}}</label>
                                        <p><strong>
                                                {{ $expense->remitter }}
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
