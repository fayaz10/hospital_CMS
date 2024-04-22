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
                <form action="{{ route('admission.store', $course->id) }}"
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
                                        <h3 class="m-form__heading-title">ثبت داخله شاگرد در ({{ $course->label_dr }})</h3>
                                    </div>


                                    <div class="row form-group m-form__group ">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>کورس
                                                (Unique): </label>
                                            <input type="text" name="name"
                                                   value="{{ $course->name }}"
                                                   readonly
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>نام
                                                کورس (دری): </label>
                                            <input type="text" name="label_dr"
                                                   value="{{ $course->label_dr }}"
                                                   readonly
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>کورس
                                                (English): </label>
                                            <input type="text" name="label_en"
                                                   value="{{ $course->label_en }}"
                                                   readonly
                                                   class="form-control m-input">
                                        </div>
                                    </div>

                                    <div class="m-form__section m-form__section--first">

                                        <div class="row form-group m-form__group ">
                                            <div class="col-lg-4">
                                                <label class="form-control-label"><span
                                                            class="text-danger">* </span>دوره:</label>
                                                <input type="text" name="term"
                                                       value="{{ $course->fees->term }}"
                                                       readonly
                                                       class="form-control m-input">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-control-label"><span class="text-danger">* </span>مقدار
                                                    مجموع فیس:</label>
                                                <input type="number" name="amount"
                                                       readonly
                                                       value="{{ $course->fees->amount }}"
                                                       class="form-control m-input">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-control-label"><span class="text-danger">* </span>واحد
                                                    پولی:</label>

                                                <select name="currency_id" id="currency"
                                                        readonly
                                                        class="form-control m-input">
                                                        <option value="{{$course->fees->currency->id}}">
                                                            ({{$course->fees->currency->label_dr}}) {{$course->fees->currency->symbol}}
                                                        </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"> لیست شاگردان (جستجو به اساس شماره سکوک): </label>
                                            <select name="student_id" id="students"
                                                    class="form-control m-input">
                                                <option value="">لطفا شاگرد انتخاب نمایید</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">

                                            <label class="form-control-label"><span class="text-danger">* </span> اسم، ولد و تخلص: </label>
                                            <input type="text" value="" id="name-holder"
                                                   class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label">مقدار تخفیف (%):</label>
                                            <input type="number" value="{{old('discount')}}"
                                                   name="discount" class="form-control m-input"
                                                   placeholder="">
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
            $('#students').on("select2:selecting", function (e) {
                console.log(e.params.args.data.text);
                $('#name-holder').val(e.params.args.data.text);
            });

            $('#students').select2({
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('student.json', 'admission') }}",
                    dataType: 'json',
                    type: "get",
                    quietMillis: 50,
                    data: function (term) {
                        return {tazkira_id: term['term'], course_id: {{ $course->id }} };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                var name = item.tazkira_id;
                                name += '-' + item.name_dr + '-' + item.father_name_dr;
                                name += item.last_name_dr ? '-' +item.last_name_dr: '';
                                return {
                                    slug: item.tazkira_id,
                                    text: name ,
                                    id: item.id,
                                    disabled: item.classes_count >= 1 ? true : false
                                }
                            })
                        };
                    }
                }
            });

            $('#save-button').click(function () {
                $('#save-form').submit();
            });
        });

    </script>
@endsection

