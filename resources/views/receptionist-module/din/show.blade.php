@extends('layouts.app')

@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{ __('reception.rec_modul') }}</h3>
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
            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>    
                        <a href="{{ route('din.print', [$din->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-print"></i> <span>{{__('global.print')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('din.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('din.edit', $din->id) }}" class="btn btn-secondary">
                            <span>
                                <i class="la la-pencil"></i> <span>{{__('global.gol_edit')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                    href="{{ route('din.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
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
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"> 
                                {{__('finance.dCategory')}}</label>
                                    <p><strong>{{ app()->isLocale('en') ? $din->category->label_en : $din->category->label_dr }}</strong>
                                    </p>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('finance.dSubject')}}</label>
                                    <p><strong>{{ $din->subject }}</strong></p>
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">
                                    {{__('finance.dType')}}
                                </label>
                                <p><strong>{{__("finance.{$din->type}")}}</strong></p>
                            </div>
                        </div>
                        
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('reception.pay_date')}}</label>
                                <p><strong>{{ $din->profit->payment_date }}</strong></p>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('reception.docy_Fvalue')}}</label>
                                <p><strong>{{ $din->profit->totalAmount }} {{ app()->isLocale('en') ? $din->profit->currency->label_en : $din->profit->currency->label_dr}}</strong></p>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('reception.pay_tax')}}</label>
                                <p><strong>{{ $din->profit->taxes }}
                                    {{ app()->isLocale('en') ? $din->profit->currency->label_en : $din->profit->currency->label_dr}}</strong></p>
                            </div>

                        </div>

                        <div class="form-group m-form__group row">

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('pharmacist.pre_docName')}}</label>
                                <p><strong>{{ optional($din->doctor)->name }}</strong></p>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('pharmacist.pre_patientRecord')}}</label>
                                <p><strong>{{ optional($din->patient)->record_no . ' (' . optional($din->patient)->name .')' }}</strong></p>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('global.dossier_no')}}
                                </label>
                                <p><strong>{{ $din->dossier_no}}</strong></p>
                            </div>

                        </div>

                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label">
                                {{__('reception.pay_cashier')}}</label>
                                <p><strong>{{ $din->profit->recipient }}</strong></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">

                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label">{{__("finance.description")}}</label>
                                <textarea name="description" cols="30" rows="10"
                                    class="form-control m-input">{{ $din->description }}</textarea>
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
