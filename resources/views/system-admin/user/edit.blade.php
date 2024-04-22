@extends('layouts.app')

@section('sidebar')
@include('system-admin.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">مادیول کاربران</h3>
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
                            <i class="la la-user"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('profile.user_edit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
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
            <form action="{{ url('/admin/user/' . $user->id) }}" id="save-form" enctype="multipart/form-data" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                @csrf()
                @method('put')
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-10 offset-xl-1 col-md-10 offset-md-1">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{__('profile.full_info')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* {{__('profile.user_regis')}}</label>
                                        <input type="text" value="{{ $user->email }}" name="email" required class="form-control m-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">* {{__('admin.adm_EnName')}}</label>
                                        <input type="text" value="{{ $user->name }}" name="name" required class="form-control m-input" placeholder="">
                                    </div>
                                    <div class="col-lg-6 m-form__group-sub">
                                        <label class="form-control-label">* {{__('admin.adm_FrName')}}</label>
                                        <input type="text" value="{{ $user->name_dr }}" name="name_dr" required class="form-control m-input" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* {{__('profile.prfilePic')}}</label>
                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input">
                                            <label class="custom-file-label" for="customFile">{{__('profile.user_photo')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">{{__('admin.usr_access2')}}</label>
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
                                        <label class="form-control-label">{{__('admin.usr_decreas')}}</label>
                                        <select name="roles[]" id="roles" multiple class="form-control m-input">
                                            @foreach(\App\Models\SystemAdmin\Role::all() as $role)
                                            <option value="{{ $role->id }}">{{ $role->label_en }} ->
                                                {{ $role->label_dr }}</option>
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

@section('scripts')
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">

    var mod = '{{$mod}}';
    var perm = '{{$perm}}';

    $(document).ready(function() {

        $('#modules').select2({
            placeholder: 'لطفا انتخاب نمایید',
            tag: true
        }).val(JSON.parse(mod)).trigger('change');

        $('#roles').select2({
            placeholder: 'لطفا انتخاب نمایید',
            tag: true
        }).val(JSON.parse(perm)).trigger('change');

    });

    $('#save-button').click(function() {
        $('#save-form').submit();
    });
</script>
@endsection
