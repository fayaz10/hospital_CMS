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
                        <a href="{{route('student.index')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                <form action="{{ route('student.update',$student->id) }}" 
                        id="save-form"
                        enctype="multipart/form-data" 
                        class="m-form m-form--label-align-left m-form--state col-12"
                        method="post">
                    {{ csrf_field() }}
                    {{method_field('put')}}
                    <!--begin: Form Body -->
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 ">
                            @include('errors.validation-errors')

                                <!--Student Information -->
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title">معلومات  شاگرد</h3>
                                    </div>
                                    <div class="row">
                                            <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                  
                                                        <label class="form-control-label">*   اسم  </label>
                                                    <input type="text" value="{{old('student_name',$student->student_name)}}"  name="student_name" required class="form-control m-input">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                        <label class="form-control-label"> ولد </label>
                                                        <input type="text" value="{{old('student_father_name',$student->student_father_name)}}"  name="student_father_name" class="form-control m-input"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                            <label class="form-control-label"> ولدیت </label>
                                                            <input type="text" value="{{old('student_grandfather_name',$student->student_grandfather_name)}}"  name="student_grandfather_name" class="form-control m-input"
                                                                placeholder="">
                                                        </div>
                                                </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                            <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                  
                                                        <label class="form-control-label">    ایمیل آدرس </label>
                                                    <input type="email" value="{{old('student_email',$student->student_email_address)}}"  name="student_email" required class="form-control m-input">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                        <label class="form-control-label">  شماره تماس</label>
                                                        <input type="text" value="{{old('student_mobile_number',$student->student_mobile_number)}}"  name="student_mobile_number" class="form-control m-input"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                            <label class="form-control-label"> صنف</label>
                                                            <select  class="form-control m-input course_sub_name" id="course_sub_name" name="course_sub_name_id">
                                                            <option value="{{$student->student_class->id}}">{{$student->student_class->course->course_name.' '.$student->student_class->name}}</option>
                                                            @foreach($course_sub_names as $course_sub_name)
                                                            <option value="{{$course_sub_name->id}}">{{$course_sub_name->course->course_name.' '.$course_sub_name->name}}</option>
                                                            @endforeach
                                                            </select>
                                                            
                                                        </div>
                                                </div>
                                    </div>

                                

                                    



                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label class="form-control-label"> عکس شاگرد</label>
                                            <div class="custom-file">
                                                <div class="form-group m-form__group">
                                                   
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" name="student_photo" class="custom-file-input" id="customFile">
                                                        <label class="custom-file-label" for="customFile">عکس جدید را انتخاب نمایید</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <label class="form-control-label">عکس قبلی شاگرد </label>
                                        <img src="{{asset('student/photos/'.$student->student_photo)}}" style="width:100px;heigth:100px"/>
                                            
                                        </div>
                                    </div>

                                    
                                </div>
                                <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading ">
                                            <h3 class="m-form__heading-title">آدرس  شاگرد</h3>
                                        </div>
                                    <div class="row">
                                            <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                  
                                                        <label class="form-control-label">     ولایت </label>
                                                        <input type="text" value="{{old('province',$student->student_address->province)}}"  name="province" required class="form-control m-input">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group ">
                                                        <label class="form-control-label">   ولسوالی</label>
                                                        <input type="text"  name="district"  value="{{old('district',$student->student_address->district)}}"  class="form-control m-input"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                            <label class="form-control-label"> ناحیه</label>
                                                    <input type="text"  name="region" value="{{old('region',$student->student_address->region)}}" class="form-control m-input"
                                                            placeholder="">
                                                            
                                                        </div>
                                                </div>

                                                <div class="col-lg-4">
                                                        <div class="form-group m-form__group ">
                                                      
                                                            <label class="form-control-label">     نمبر سرک </label>
                                                        <input type="text" value="{{old('street_number',$student->student_address->street_number)}}"  name="street_number" required class="form-control m-input">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-lg-4">
                                                        <div class="form-group m-form__group ">
                                                            <label class="form-control-label">   نمبر خانه</label>
                                                        <input type="text" value="{{old('house_number',$student->student_address->house_number)}}"  name="house_number" class="form-control m-input"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                   
                                    </div>
                                </div>


                                <br>

                                <!-- END Student Information -->

                                <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading ">
                                            <h3 class="m-form__heading-title">معلومات ولی شاگرد</h3>
                                        </div>
                                        <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group m-form__group ">
                                                      
                                                            <label class="form-control-label">*  اسم ولی شاگرد  </label>
                                                        <input type="text" value="{{old('student_guardian_name',$student->student_guardian->student_guardian_name)}}"  name="student_guardian_name" required class="form-control m-input">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                            <div class="form-group m-form__group ">
                                                          
                                                                <label class="form-control-label">*  قرابت ولی  با شاگرد  </label>
                                                                <input type="text"  value="{{old('student_guardian_relationship',$student->student_guardian->student_guardian_relationship)}}"  name="student_guardian_relationship" required class="form-control m-input">
                                                            </div>
                                                        </div>
                                                   
                                                    <div class="col-lg-6">
                                                        <div class="form-group m-form__group ">
                                                            <label class="form-control-label"> نمبرتماس ولی شاگرد </label>
                                                        <input type="text"  name="student_guardian_mobile_number" value="{{old('student_guardian_mobile_number',$student->student_guardian->stduent_guardian_mobile_number)}}" class="form-control m-input"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group m-form__group">
                                                                <label class="form-control-label">  نمبر تماس شخص سومی</label>
                                                        <input type="text"  name="third_person_mobile_number" value="{{old('third_person_mobile_number',$student->student_guardian->third_person_mobile_number)}}" class="form-control m-input"
                                                                    placeholder="">
                                                            </div>
                                                    </div>
                                        </div>
    
                                        <br>
    
                                     
    
    
    
                                        
    
                                        
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
        // $(document).ready(function(){
        //     $('.course_sub_name').select2();
        // });
        $('#save-button').click(function(){
            $('#save-form').submit();
        });
    </script>
@endsection

