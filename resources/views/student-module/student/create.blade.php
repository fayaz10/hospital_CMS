@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
    @include('student-module.partials.sidebar')
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
                                ایجاد شاگرد جدید
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('student.index')}}"
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
                <form action="{{ route('student.store') }}"
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
                                        <h3 class="m-form__heading-title">معلومات شخصی شاگرد</h3>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"><span class="text-danger">* </span> اسم
                                                (دری): </label>
                                            <input type="text" value="{{old('name_dr')}}" name="name_dr"
                                                   required class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> ولد
                                                (دری):</label>
                                            <input type="text" value="{{old('father_name_dr')}}"
                                                   name="father_name_dr" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> ولدیت
                                                (دری):</label>
                                            <input type="text" value="{{old('grand_father_name_dr')}}"
                                                   name="grand_father_name_dr" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"> اسم (English): </label>
                                            <input type="text" value="{{old('name_en')}}" name="name_en"
                                                   required class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"> ولد (English):</label>
                                            <input type="text" value="{{old('father_name_en')}}"
                                                   name="father_name_en" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"> ولدیت (English):</label>
                                            <input type="text" value="{{old('grand_father_name_en')}}"
                                                   name="grand_father_name_en" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"><span class="text-danger">* </span> شماره
                                                سکوک (تذکیره): </label>
                                            <input type="text" value="{{old('tazkira_id')}}" name="tazkira_id"
                                                   required class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> تاریخ
                                                تولد (شمسی):</label>
                                            <input type="text" value="{{old('dob_dr')}}"
                                                   name="dob_dr" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> تاریخ
                                                تولد (میلادی):</label>
                                            <input type="date" value="{{old('dob_en')}}"
                                                   name="dob_en" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"><span class="text-danger">* </span>عکس (3x4):</label>
                                            <div class="custom-file">
                                                <div class="form-group m-form__group">

                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" name="student_photo" class="custom-file-input"
                                                               id="customFile">
                                                        <label class="custom-file-label" for="customFile">عکس را انتخاب
                                                            نمایید</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">

                                            <label class="form-control-label">ضمایم (از قبیل تذکیره شاگرد، ولی شاگرد و دیگر ضایم ضروری):</label>
                                            <div class="custom-file">
                                                <div class="form-group m-form__group">

                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" name="attachments[]"
                                                               multiple
                                                               class="custom-file-input"
                                                               id="customFile">
                                                        <label class="custom-file-label" for="customFile">ضمایم را انتخاب
                                                            نمایید</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">راه های ارتباطی شاگرد</h3>
                                    </div>

                                    <div class="row form-group m-form__group ">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"> ایمیل آدرس :</label>
                                            <input type="email" value="{{old('student_email')}}"
                                                   name="student_email" required class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"> شماره تماس (اول): </label>
                                            <input type="text" value="{{old('student_number_1')}}"
                                                   name="student_number_1" class="form-control m-input"
                                                   placeholder="">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"> شماره تماس (دوم):</label>
                                            <input type="text" value="{{old('student_number_2')}}"
                                                   name="student_number_2" class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>

                                </div>

                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">آدرس شاگرد</h3>
                                    </div>
                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"><span class="text-danger">* </span> ولایت </label>
                                            <input type="text" value="{{old('province')}}" name="province" required
                                                   class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> ولسوالی</label>
                                            <input type="text" name="village" value="{{old('village')}}"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> ناحیه</label>
                                            <input type="text" name="district" value="{{old('district')}}"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">

                                            <label class="form-control-label"> نمبر سرک </label>
                                            <input type="text" value="{{old('street_number')}}" name="street_number"
                                                   required class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"> نمبر خانه</label>
                                            <input type="text" value="{{old('house_number')}}" name="house_number"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label">ملاحظات:</label>
                                            <input type="text" value="{{old('considerations')}}" name="considerations"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>

                                    </div>
                                </div>

                                <!-- END Student Information -->
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">معلومات ولی شاگرد</h3>
                                    </div>
                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span> اسم ولی شاگرد:</label>
                                            <input type="text" value="{{old('guardian_name')}}"
                                                   name="guardian_name" required
                                                   class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>قرابت با شاگرد:</label>
                                            <input type="text" value="{{old('guardian_relation')}}"
                                                   name="guardian_relation" required
                                                   class="form-control m-input">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-control-label"><span class="text-danger">* </span>شماره تماس:</label>
                                            <input type="text" value="{{old('guardian_number')}}"
                                                   name="guardian_number" required
                                                   class="form-control m-input">
                                        </div>
                                    </div>
                                    <div class="row form-group m-form__group">
                                        <div class="col-lg-4">
                                            <label class="form-control-label">شماره تماس (دوم):</label>
                                            <input type="text" name="guardian_number_1"
                                                   value="{{old('guardian_number_1')}}"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label">ایمیل آدرس ولی:</label>
                                            <input type="text" name="guardian_email"
                                                   value="{{old('guardian_email')}}"
                                                   class="form-control m-input"
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

    <script type="text/javascript">
        $('#save-button').click(function () {
            $('#save-form').submit();
        });
    </script>
@endsection

