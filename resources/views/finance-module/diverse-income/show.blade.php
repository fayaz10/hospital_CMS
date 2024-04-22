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
                        <a href="{{ route('income.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            @include('errors.alert')

            <hr>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                        @include('errors.validation-errors')

                        <div class="m-form__heading mt-3">
                            <h2 class="m-form__heading-title">{{__('finance.dInfoNewDiverIncome')}}</h2>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label"> 
                                {{__('finance.dCategory')}}</label>
                                    <p><strong>{{ app()->isLocale('en') ? $diverse_income->category->label_en : $diverse_income->category->label_dr }}</strong>
                                    </p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('finance.dSubject')}}</label>
                                    <p><strong>{{ $diverse_income->subject }}</strong></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                    {{__('finance.dType')}}
                                </label>
                                <p><strong>{{__("finance.{$diverse_income->type}")}}</strong></p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('reception.pay_date')}}</label>
                                <p><strong>{{ $diverse_income->profit->payment_date }}</strong></p>
                            </div>


                        </div>
                        <div class="form-group m-form__group row">

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">{{__('reception.docy_Fvalue')}}</label>
                                <p><strong>{{ $diverse_income->profit->amount }} {{ app()->isLocale('en') ? $diverse_income->profit->currency->label_en : $diverse_income->profit->currency->label_dr}}</strong></p>
                            </div>

                            <div class="col-lg-6 m-form__group-sub">
                                <label class="form-control-label">
                                    {{__('reception.docy_currency')}}
                                </label>
                                <p><strong>{{ app()->isLocale('en') ? $diverse_income->profit->currency->label_en : $diverse_income->profit->currency->label_dr}}</strong></p>
                            </div>

                        </div>

                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('reception.pay_cashier')}}</label>
                                <p><strong>{{ $diverse_income->profit->recipient }}</strong></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label">{{__("finance.description")}}</label>
                                <textarea name="description" cols="30" rows="10"
                                    class="form-control m-input">{{ $diverse_income->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>

<script type="text/javascript">
    $('#save-button').click(function () {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });

</script>
@endsection
