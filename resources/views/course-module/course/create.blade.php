@extends('layouts.app')

{{--@section('styles')--}}
{{--<link href="{{ asset('css/select2.min.css') }}" rel="text/stylesheet">--}}
{{--@endsection--}}

@section('sidebar')
    @include('course-module.partials.sidebar')
@endsection


@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">مادیول شاگردان</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">صفحه نخست</span>
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
                            <h3 class="m-portlet__head-text">
                                ایجاد کورس جدید
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('course.index')}}"
                           class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>برگشت</span>
                            </span>
                        </a>
                        <div class="btn-group">
                            <button type="button"
                                    id="save-button"
                                    class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                                <span>
                                    <i class="la la-check"></i>
                                    <span>ثبت</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
                <form action="{{ route('course.store') }}"
                      id="save-form"
                      enctype="multipart/form-data"
                      class="m-form m-form--label-align-left m-form--state col-12"
                      method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 ">
                            @include('errors.validation-errors')

                            <!--Student Information -->
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">معلومات کورس (صنف)</h3>
                                    </div>


                                    <div class="row form-group m-form__group ">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>کورس
                                                (Unique): </label>
                                            <input type="text" name="name" required
                                                   value="{{ old('name') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>نام
                                                کورس (دری): </label>
                                            <input type="text" name="label_dr" required
                                                   value="{{ old('label_dr') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>کورس
                                                (English): </label>
                                            <input type="text" name="label_en" required
                                                   value="{{ old('label_en') }}"
                                                   class="form-control m-input">
                                        </div>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-12">
                                            <label class="form-control-label"> مضامین </label>
                                            <select multiple name="subjects[]" id="subject"
                                                    class="form-control m-input subject">
                                                @foreach($subjects as $subject)
                                                    <option value="{{$subject->id}}">({{$subject->name}}) {{$subject->label_dr}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">فیس کورس (صنف)</h3>
                                    </div>

                                    <div class="row form-group m-form__group ">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>دوره:</label>
                                            <input type="text" name="term" required
                                                   value="{{ old('term') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>مقدار مجموع فیس:</label>
                                            <input type="number" name="amount" required
                                                   value="{{ old('amount') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>واحد پولی:</label>
                                            <select name="currency_id"
                                                    class="form-control m-input subject">
                                                @foreach(\App\Models\FinanceModule\Currency::all() as $currency)
                                                    <option value="{{$currency->id}}">({{$currency->label_dr}}) {{$currency->symbol}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row form-group m-form__group ">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>تاریخ شروع:</label>
                                            <input type="date" name="start_date" required
                                                   value="{{ old('start_date') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>تاریخ ختم:</label>
                                            <input type="date" name="end_date" required
                                                   value="{{ old('end_date') }}"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label">ملاحظات:</label>
                                            <input type="text" name="considerations" required
                                                   value="{{ old('considerations') }}"
                                                   class="form-control m-input">
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

        $(document).ready(function () {
            $('.subject').select2();

            $('#save-button').click(function () {
                $('#save-form').submit();
            });
        });

    </script>
@endsection

