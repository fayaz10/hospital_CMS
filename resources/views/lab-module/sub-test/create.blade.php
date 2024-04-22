@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

@section('sidebar')
@include('lab-module.partials.sidebar')
@endsection


@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('lab.lab_mod')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{route('test.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('lab.lab_modTest')}}</span>
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
                        <h3 class="m-subheader__title m-subheader__title--separator">
                            {{__('lab.lab_addtest')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{route('test.index')}}"
                        class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button"
                            class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{__('global.gol_save')}}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('sub-test.store') }}" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">*</span>
                                            {{__('global.sub_test_name')}}</label>
                                        <input type="text" value="{{ old('name') }}" name="name" required
                                            class="form-control m-input" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label">
                                            {{__('global.original_test_name')}}</label>
                                            <select class="form-control m-input" name="tests[]" id="doctor" multiple>
                                                @foreach(\App\Models\LabModule\Test::all() as $test)
                                                    <option value="{{ $test->id }}">
                                                        {{ $test->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label">{{__('pharmacist.r_range')}}</label>
                                        <textarea name="range" rows="10" class="form-control"></textarea>
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

@section('scripts')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });

    $(document).ready(function () {
        $('#doctor').select2({
            placeholder: 'لطفا انتخاب نمایید',
            multiple:true,
            dir: '{{app()->isLocale("en") ? "ltr" : "rtl"}}',
            tag: true
        });
    });
</script>
@endsection
