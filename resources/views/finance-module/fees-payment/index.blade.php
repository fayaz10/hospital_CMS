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

                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-6 order-2 order-xl-1">
                        </div>
                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                            {{--<a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"--}}
                            {{--href="{{ url('/finance/fees/create') }}">--}}
                            {{--<span> <i class="la la-plus"></i> <span>ایجاد</span> </span> </a>--}}
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table m-table m-table--head-separator-primary">
                    <thead class="table-inverse">
                    <tr>
                        <th>شماره</th>
                        <th>عکس</th>
                        <th>شماره سکوک</th>
                        <th>مشخصات شاگرد</th>
                        <th>صنف</th>
                        <th>مقدار تادیه</th>
                        {{--<th scope="col" style="width: 45%;">فیصدی پرداخت ها</th>--}}
                        <th>مدت اعتبار</th>
                        {{--<th>گیرنده</th>--}}
                        <th>&nbsp;عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fees as $key => $fee)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <img src="{{ url('student_pic/photos/' . $fee->student->photo)}}" alt="student img"
                                     style="width:50px;height:50px;">
                            </td>
                            <td>{{ $fee->student->tazkira_id }}</td>
                            <td>{{ $fee->student->name_dr }} - {{ $fee->student->father_name_dr }}
                                - {{ $fee->student->last_name_dr }}</td>
                            <td>{{ $fee->course->label_dr }}</td>

                            @php
                                //$percent = ceil($student->paidAmountInPercentage($course->id, $course));
                            @endphp

                            <td>{{ $fee->profit->amount }} ({{ $fee->profit->currency->symbol }})</td>
                            {{--<td>--}}
                                {{--<div class="progress m-progress--lg">--}}
                                    {{--<div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="15"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100">35%</div>--}}
                                    {{--<div class="progress-bar bg-info" role="progressbar" style="width: 20%"--}}
                                         {{--aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">20%</div>--}}
                                    {{--<div class="progress-bar bg-warning" role="progressbar" style="width: 25%"--}}
                                         {{--aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">25%</div>--}}
                                {{--</div>--}}
                            {{--</td>--}}

                            <td>
                                @if($fee->valid_status)
                                    <span class="text-primary">{{ $fee->valid_duration }} روز دیگر اعتبار دارد</span>
                                @else
                                    <span class="text-danger">{{ $fee->valid_duration }} روز پیش فاقد اعتبار شده است</span>
                                @endif

                            </td>
                            {{--<td>{{ $fee->profit->recipient }}</td>--}}
                            {{--<td>{{ $fee->profit->registrar->name }}</td>--}}
                            <td><a href="{{ url('/finance/fees/' . $fee->id) }}"> <i class="flaticon-eye"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
