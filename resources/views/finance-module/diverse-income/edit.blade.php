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
                            <i class="flaticon-coins"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('finance.dEdit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('visit.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
            <form action="{{ route('diverse-income.update', [$diverse_income->id]) }}" id="save-form" enctype="multipart/form-data" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                @method('PUT')
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            @include('errors.validation-errors')

                            <div class="m-form__heading mt-3">
                                <h2 class="m-form__heading-title">{{__('finance.dEditInfo')}}</h2>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label"> <span class="text-danger">* </span>{{__('finance.dCategory')}}</label>
                                    <select class="form-control m-input" name="category_id" onchange="selectDoctor(this)" id="doctor">
                                        @foreach(\App\Models\FinanceModule\DiverseCategory::all() as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $diverse_income->category_id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ app()->isLocale('en') ? $category->label_en : $category->label_dr }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label"><span class="text-danger">* </span>{{__('finance.dSubject')}}</label>
                                    <input type="text" name="subject" required class="form-control m-input" value="{{ $diverse_income->subject }}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">
                                        <span class="text-danger">* </span>{{__('finance.dType')}}
                                    </label>
                                    <select class="form-control m-input" name="type">
                                        @foreach(\App\Models\FinanceModule\DiverseIncome::getTypeValues() as $type)
                                        <option value="{{ $type }}" {{ $type == $diverse_income->type ? 'selected' : '' }}>
                                            {{__("finance.{$type}")}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label"><span class="text-danger">* </span>{{__('reception.pay_date')}}</label>
                                    <input type="date" name="payment_date" required class="form-control m-input" value="{{ $diverse_income->profit->payment_date }}" placeholder="">
                                </div>


                            </div>
                            <div class="form-group m-form__group row">

                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label"><span class="text-danger"><span class="text-danger">* </span> </span>{{__('reception.docy_Fvalue')}}</label>
                                    <input type="number" name="amount" required class="form-control m-input" value="{{ $diverse_income->profit->amount }}" placeholder="">
                                </div>

                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">
                                        <span class="text-danger">* </span>{{__('reception.docy_currency')}}
                                    </label>
                                    <select class="form-control m-input" name="currency_id">
                                        @foreach(\App\Models\FinanceModule\Currency::all() as $type)
                                        <option value="{{ $type->id }}" {{ $type->id == $diverse_income->profit->currency_id ? 'selected' : '' }}>
                                            {{ $type->label_dr }} ({{ $type->symbol }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group m-form__group row">

                                <div class="col-lg-12 m-form__group-sub">
                                    <label class="form-control-label"><span class="text-danger">* </span>{{__('reception.pay_cashier')}}</label>
                                    <input type="text" name="recipient" required class="form-control m-input" value="{{ $diverse_income->profit->recipient }}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">

                                <div class="col-lg-12 m-form__group-sub">
                                    <label class="form-control-label">{{__("finance.description")}}</label>
                                    <textarea name="description" cols="30" rows="10" class="form-control m-input">{{ $diverse_income->description }}</textarea>
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
@section('scripts')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });
</script>
@endsection