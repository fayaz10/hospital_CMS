@extends('layouts.app')


@section('sidebar')
    @include('finance-module.partials.sidebar')
@endsection


@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">مادیول مالی</h3>
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

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-6 order-2 order-xl-1">
                        </div>
                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a href="{{ url('/finance/fees/' . $fee->id . '/edit') }}"
                               class="btn btn-secondary">
                                <span> <i class="la la-print"></i> <span>پرنت بل</span> </span> </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a href="{{ url('/finance/fees/' . $fee->id . '/edit') }}"
                               class="btn btn-secondary">
                                <span> <i class="la la-pencil"></i> <span>ویرایش</span> </span> </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            {{--<a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"--}}
                            {{--href="{{ url('/finance/fees/create') }}">--}}
                            {{--<span> <i class="la la-plus"></i> <span>ایجاد</span> </span> </a>--}}
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                        </div>
                    </div>
                </div>
                <hr>


                <div class="m-form__section m-form__section--first">
                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title">معلومات شاگرد</h3>
                    </div>

                    <div class="form-group m-form__group row">

                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u> صنف </u></label>
                            <p><strong>{{ $fee->course->label_dr }} ({{ $fee->course->name }})</strong></p>
                        </div>

                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>شماره سکوک :</u></label>
                            <p><strong>{{ $fee->student->tazkira_id }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>اسم، ولد و تخلص:</u></label>
                            <p><strong>{{ $fee->student->name_dr }} - {{ $fee->student->father_name_dr }}
                                    - {{ $fee->student->last_name_dr }}</strong></p>
                        </div>

                    </div>

                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title">معلومات پرداخت فیس</h3>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>تاریخ پرداخت :</u></label>
                            <p><strong>{{ $fee->profit->payment_date }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>مدت اعتبار از :</u></label>
                            <p><strong>{{ $fee->valid_date }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>مدت اعتبار الی:</u></label>
                            <p><strong>{{ $fee->expire_date }}</strong></p>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>مقدار پول:</u></label>
                            <p><strong>{{ !$fee->punishment ? $fee->profit->amount : $fee->profit->amount - $fee->punishment }} ({{ $fee->profit->currency->symbol }})</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>واحد پولی:</u></label>
                            <p><strong>{{ $fee->profit->currency->label_dr }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>طریقه پرداخت:</u></label>
                            <p><strong>{{ $fee->profit->paymentMethod->label_dr }}</strong></p>
                        </div>
                    </div>


                    <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>گیرنده پرداخت: </u></label>
                            <p><strong>{{ $fee->profit->recipient }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>جریمه:</u></label>
                            <p><strong>{{ $fee->punishment ? $fee->punishment . ' ' . $fee->profit->currency->label_dr : null }}</strong></p>
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"><u>ملاحظات:</u></label>
                            <p><strong>{{ $fee->considerations }}</strong></p>
                        </div>
                    </div>

                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title">پرداخت های شاگرد در این صنف</h3>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="table mt-2">

                            <!--begin::Table-->
                            <table class="table">

                                <!--begin::Thead-->
                                <thead>
                                <tr>
                                    <th>شماره</th>
                                    <th>تاریخ پرداخت</th>
                                    <th>مدت اعتبار از</th>
                                    <th>مدت اعتبار الی</th>
                                    <th>مقدار پرداخت</th>
                                    <th>مدت اعتبار</th>
                                    <th>مشاهده</th>
                                </tr>
                                </thead>

                                <!--end::Thead-->

                                <!--begin::Tbody-->
                                <tbody>
                                    @foreach($fee->student->paidFees($fee->class_id) as $key => $paidFee)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $paidFee->profit->payment_date }}</td>
                                            <td>{{ $paidFee->valid_date->format('Y-m-d') }}</td>
                                            <td>{{ $paidFee->expire_date->format('Y-m-d') }}</td>
                                            <td>{{ $paidFee->profit->amount }} <u>{{ $paidFee->profit->currency->label_dr }}</u></td>
                                            <td>{{ $paidFee->duration }} روز</td>
                                            <td>
                                                {{--<button>--}}
                                                <a class="btn m-btn--pill btn-secondary btn-sm {{ $paidFee->id == $fee->id ? 'disabled' : '' }}" href="{{ url('finance/fees/' . $paidFee->id) }}">معلومات بیشتر</a>
                                                {{--</button>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <!--end::Tbody-->
                            </table>

                            <!--end::Table-->
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
