@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
    @include('course-module.partials.sidebar')
@endsection


@section('content')
<div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">مادیول کورس و مضامین</h3>
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
                                  تصحیح مضمون
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('subject.index')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                <form action="{{ route('subject.update',$subject->id) }}" 
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
                                        <h3 class="m-form__heading-title"> مضمون  </h3>
                                    </div>
                                    <div class="row">
                                            <div class="col-lg-6">
                                                    <div class="form-group m-form__group ">
                                                        <label class="form-control-label">*   نام مضمون  </label>
                                                    <input type="text" value="{{old('subject_name',$subject->subject_name)}}"  name="subject_name" required class="form-control m-input">
                                                    </div>
                                                </div>
                                            </div>

                                    <br>

                                  

                                    



                                   
                                <!-- END Student Information -->

                               


                                



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
        $('#save-button').click(function(){
            $('#save-form').submit();
        });
    </script>
@endsection

