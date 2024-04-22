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
            <h3 class="m-subheader__title m-subheader__title--separator">{{ __('reception.rec_modul') }}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{ route('doctor.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">{{ __('reception.docy_modul')}}</span>
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
                        {{ __('reception.docy_add')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                        <a href="{{route('doctor.index')}}"
                           class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>{{ __('global.gol_back') }}</span>                                
                            </span>
                        </a>
                        <div class="btn-group">
                            <button type="button"
                                    id="save-button"
                                    class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                                <span>
                                    <i class="la la-check"></i>
                                    <span>{{ __('global.gol_save') }}</span>
                                </span>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('doctor.store') }}" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{ __('reception.docy_add') }}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i>{{ __('reception.docy_name') }}</label>
                                        <input type="text" value="{{ old('first_name') }}" name="first_name" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">  <i class="text-danger">*</i>{{__('reception.docy_surname')}}</label>
                                        <input type="text" value="{{ old('last_name') }}" name="last_name" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i>{{__('reception.docy_specialze')}}</label>
                                        <input type="text" value="{{ old('specialist') }}" name="specialist" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i>{{__('reception.docy_fees')}}</label>
                                        <input type="number" value="{{ old('visit_fee') }}" name="visit_fee" required class="form-control m-input"
                                            placeholder="">
                                    </div>
                                   
                                </div>
                                <div class="form-group m-form__group row">
                                <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"> <i class="text-danger">*</i>{{__('reception.docy_currency')}}</label>
                                        <select class="form-control m-input" name="currency_id">
                                            @foreach(\App\Models\FinanceModule\Currency::all() as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->label_dr }} ({{ $type->symbol }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label class="form-control-label">{{__('profile.user_regis')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- <label class="m-radio m-radio--single m-radio--state"> -->
                                                        <input type="checkbox" name="make_user">
                                                    <!-- </label> -->
                                                    &nbsp;&nbsp;&nbsp;
                                                        <span>{{__('profile.user_create')}}</span>
                                                </span>
                                            </div>
                                            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>                                    
                                        <span class="m-form__help">{{__('profile.user_alert')}}</span>
                                        
                                    </div>
                              
                                    <div class="col-lg-6">
                                        <label class="form-control-label"><i class="text-danger">*</i>{{__('profile.prfilePic')}}</label>
                                        
                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input">
                                            <label class="custom-file-label" for="customFile">{{__('profile.user_chosePhoto')}}</label>
                                        </div>
                                    </div>
                               
                                </div>
                                </div>

                              

                                {{-- <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">اجازه دسترسی به این مادیول ها</label>
                                        <select name="modules[]" id="modules" multiple class="form-control m-input">
                                            @foreach(\App\Models\SystemAdmin\Module::all() as $module)
                                            <option value="{{ $module->id }}">{{ $module->label_en }} ->
                                                {{ $module->label_dr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">تفویض این صلاحیت ها</label>
                                        <select name="roles[]" id="roles" multiple class="form-control m-input">
                                            @foreach(\App\Models\SystemAdmin\Role::all() as $role)
                                            <option value="{{ $role->id }}">{{ $role->label_en }} ->
                                                {{ $role->label_dr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

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
<!-- <script src="{{asset('js/select2.min.js')}}"></script> -->

<script type="text/javascript">

    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });
        
        form.submit();
    });

</script>
@endsection
