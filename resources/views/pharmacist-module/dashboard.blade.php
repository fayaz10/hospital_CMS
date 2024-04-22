@extends('layouts.app')


@section('sidebar')
@include('pharmacist-module.partials.sidebar')
@endsection


@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('pharmacist.med_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('global.gol_fpage')}}</span>
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
<!-- // ****************************************************************************************** -->
<div class="m-content">
    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceDesc')}}
                            </span>
                            <span class="m-widget24__stats m--font-brand">
                                {{$medicinePurchaseToday->count()}}
                            </span>
                            <div class="m--space-10"></div>
                        </div>
                    </div>


                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceDescW')}}
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {{$medicinePurchaseInThisWeek->count()}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceDescM')}}
                            </span>
                            <span class="m-widget24__stats m--font-danger">
                                {{ $medicinePurchaseInThisMonth->count() }}
                            </span>
                            <div class="m--space-10"></div>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>

            </div>
        </div>
        <!-- second row -->
    </div>
    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence2')}}
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceToday')}}
                            </span>
                            <span class="m-widget24__stats m--font-brand">
                                {{ $medicinePurchaseToday->sum('spend.amount') }}
                            </span>
                            <div class="m--space-20"></div>
                        </div>
                    </div>


                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence2')}}
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceWeek')}}
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {{ $medicinePurchaseInThisWeek->sum('spend.amount')}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_expence2')}}
                                {{__('pharmacist.med_expence')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_expenceMonth')}}
                            </span>
                            <span class="m-widget24__stats m--font-danger">
                                {{ $medicinePurchaseInThisMonth->sum('spend.amount')}}
                            </span>
                            <div class="m--space-10"></div>
                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>

            </div>
        </div>
    </div>

    <!-- Prescriptions -->
    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.side_prescription')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.pre_today')}}
                            </span>
                            <span class="m-widget24__stats m--font-brand">
                                {{ 
                                    $prescriptions->where(
                                        'created_at',
                                        '>=', 
                                        \Carbon\Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))->count()
                                }}
                            </span>
                            <div class="m--space-20"></div>
                        </div>
                    </div>


                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.side_prescription')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.pre_week')}}
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {{ 
                                    $prescriptions->where(
                                        'created_at',
                                        '>=', 
                                        \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'))->count()
                                }}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.side_prescription')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.pre_month')}}
                            </span>
                            <span class="m-widget24__stats m--font-danger">
                                {{ $prescriptions->count()}}
                            </span>
                            <div class="m--space-10"></div>
                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>

            </div>
        </div>
    </div>

    <div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_medList')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_medicines')}}
                            </span>
                            <span class="m-widget24__stats m--font-brand">
                                {{ \App\Models\pharmacist\Medicine::count()}}
                            </span>
                            <div class="m--space-20"></div>
                        </div>
                    </div>


                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_medList')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_medicinesLess10')}}
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {{ $medicineStock->count()}}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">

                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                {{__('pharmacist.med_medList')}}

                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                {{__('pharmacist.med_medicinesZero')}}
                            </span>
                            <span class="m-widget24__stats m--font-danger">
                                {{ $medicineStockZero->count()}}
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