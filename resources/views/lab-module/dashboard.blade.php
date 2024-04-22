@extends('layouts.app')


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
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.frst_page')}}</span>
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

    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">

                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('lab.lab_exp')}}
                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                {{ $expTodayCount }}
                            </span>
                            <span class="m-widget24__desc">
                                {{__('lab.lab_ExpThisDay')}}
                            </span>

                            <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('lab.lab_exp')}}
                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                {{ $expMonthCount }}
                            </span>
                            <span class="m-widget24__desc">
                                {{__('lab.lab_ExpThisMnth')}}
                                <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('lab.lab_exp')}}
                                </span>
                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                {{ $expYearCount }}
                            </span>
                            <span class="m-widget24__desc">
                                <span class="text-primary">
                                </span> {{__('lab.lab_expYear')}}
                                <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::Total Profit-->
                </div>

                <div class="col-md-12 col-lg-6 col-xl-3">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('lab.lab_tests')}}
                            </h4>
                            <br>
                            <span class="m-widget24__stats m--font-brand">
                                {{ \App\Models\LabModule\Test::count() }}
                            </span>
                            <span class="m-widget24__desc">
                                {{__('lab.lab_exisTests')}}
                            </span>

                            <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection