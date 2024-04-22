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
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">

                    <!-- here can place a progress bar-->
                </div>
                <div class="m-portlet__head-wrapper">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-coins"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                پرداخت فیس شاگرد
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="#"
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
                <form action="{{route('finance.fees.store', $class->id)}}"
                      id="save-form"
                      enctype="multipart/form-data"
                      class="m-form m-form--label-align-left m-form--state col-12"
                      method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                @include('errors.validation-errors')
                                <div class="m-form__section m-form__section--first">
                                    @php
                                        $paidFees = $student ? $student->paidFees($class->id) : null;
                                    @endphp
                                    @if($student)
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">پرداخت های قبلی شاگرد در این صنف</h3>
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
                                                    @forelse($paidFees as $key => $paidFee)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $paidFee->profit->payment_date }}</td>
                                                            <td>{{ $paidFee->valid_date->format('Y-m-d') }}</td>
                                                            <td>{{ $paidFee->expire_date->format('Y-m-d') }}</td>
                                                            <td>{{ $paidFee->profit->amount }}
                                                                <u>{{ $paidFee->profit->currency->label_dr }}</u></td>
                                                            <td>
                                                                @if($paidFee->valid_status)
                                                                    <span class="text-primary">{{ $paidFee->valid_duration }}
                                                                        روز دیگر اعتبار دارد</span>
                                                                @else
                                                                    <span class="text-danger">{{ $paidFee->valid_duration }}
                                                                        روز پیش فاقد اعتبار شده است</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{--<button>--}}
                                                                <a class="btn m-btn--pill btn-secondary btn-sm"
                                                                   href="{{ url('finance/fees/' . $paidFee->id) }}">معلومات
                                                                    بیشتر</a>
                                                                {{--</button>--}}
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="7">
                                                                هیچ پرداختی صورت نگرفته است.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>

                                                    <!--end::Tbody-->
                                                </table>

                                                <!--end::Table-->
                                            </div>
                                        </div>
                                    @endif

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">معلومات صنف و شاگرد</h3>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span> صنف
                                            </label>
                                            {{--<span type="text" name="name_dr" readonly required--}}
                                            {{--class="form-control m-input"--}}
                                            {{--value="{{ $class->label_dr }} {!! '<small>\'' . $class->fees->term . '\'</small>' !!}">--}}
                                            <span class="form-control m-input">
                                                {{ $class->label_dr }} {!! '<small>"' . $class->fees->term . '"</small>' !!}
                                            </span>
                                        </div>
                                        <div class="col-lg-8 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span>لیست
                                                شاگردان (جستجو به اساس شماره سکوک) :</label>
                                            <select name="student_id" id="students"
                                                    class="form-control m-input">
                                                @if($student)
                                                    <option value="{{ $student->id }}">
                                                        {{ $student->tazkira_id }} - {{ $student->name_dr }}
                                                        - {{ $student->father_name_dr }}
                                                        - {{ $student->last_name_dr }}
                                                    </option>
                                                @else
                                                    <option value="">لطفا شاگرد را انتخاب نمایید</option>
                                                    @foreach($class->students as $student)
                                                        <option value="{{ $student->id }}" {{ old('student_id') && $student->id == old('student_id') ? 'selected' : '' }}>
                                                            {{ $student->tazkira_id }} - {{ $student->name_dr }}
                                                            - {{ $student->father_name_dr }}
                                                            - {{ $student->last_name_dr }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{--<div class="col-lg-4 m-form__group-sub">--}}
                                        {{--<label class="form-control-label">--}}
                                        {{--<span class="text-danger">* </span> اسم و ولد :--}}
                                        {{--</label>--}}
                                        {{--<input type="text" name="name_dr" readonly required--}}
                                        {{--class="form-control m-input"--}}
                                        {{--value="">--}}
                                        {{--</div>--}}
                                    </div>

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">معلومات پرداخت فیس</h3>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span>تاریخ
                                                پرداخت :</label>
                                            <input type="date" name="payment_date" required class="form-control m-input"
                                                   value="{{ old('payment_date') }}"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label">
                                                <span class="text-danger">* </span>تاریخ اعتبار از :
                                            </label>
                                            <input type="date" name="valid_date" required
                                                   class="form-control m-input"
                                                   value="{{ old('valid_date') }}"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span>تاریخ انقضاء الی:</label>
                                            <input type="date" name="expire_date" required
                                                   class="form-control m-input"
                                                   value="{{ old('expire_date') }}"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4 m-form__group-sub">
                                            @php
                                            $payableAmount = null;
                                            $discountAmount = null;
                                            $discount = null;
                                            if($student){
                                                $discount = $student->classes->find($class)->pivot->discount ? $student->classes->find($class)->pivot->discount : null;
                                                $discountAmount = $discount ?
                                                    \App\iSys\Services\IncomeFormatter::toAmount($class->fees->amount, $discount) : 0;

                                                $payableAmount = ($class->fees->amount - $discountAmount) - $student->paidAmount(null, $paidFees);
                                            }
                                            @endphp
                                            <label class="form-control-label"><span class="text-danger">* </span>مقدار
                                                پول: </label>
                                            <input type="number" name="amount" required class="form-control m-input"
                                                   value="{{ old('amount') }}"
                                                   placeholder="" 
                                                   max="{{ $payableAmount }}">
                                            <span class="m-form__help text-primary">مقدار قابل تادیه {{ $payableAmount }} {{ $class->fees->currency->label_dr }} میباشد.
                                            @if($discount)
                                                {{ $discount }}% تخفیف دارد.
                                            @endif
                                            </span>
                                        </div>
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label">
                                                <span class="text-danger">* </span>واحد پولی:
                                            </label>
                                            <select class="form-control m-input" name="currency_id">
                                                @foreach($currency as $type)
                                                    <option value="{{ $type->id }}" {{ old('currency_id') && $student->id == old('currency_id') ? 'selected' : '' }}>
                                                        {{ $type->label_dr }} ({{ $type->symbol }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span>طریقه
                                                پرداخت:</label>
                                            <select class="form-control m-input" name="payment_method_id">
                                                @foreach($paymentMethods as $method)
                                                    <option value="{{ $method->id }}" {{ old('payment_method_id') && $student->id == old('payment_method_id') ? 'selected' : '' }}>
                                                        {{ $method->label_dr }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group m-form__group row">
                                        {{--<div class="col-lg-4 m-form__group-sub">--}}
                                        {{--<label class="form-control-label">تخفیف (%):</label>--}}
                                        {{--<input type="number" name="discount" class="form-control m-input"--}}
                                        {{--value="{{ old('discount') }}"--}}
                                        {{--placeholder="">--}}
                                        {{--</div>--}}

                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label"><span class="text-danger">* </span>گیرنده
                                                پرداخت: </label>
                                            <input type="text" name="recipient" required class="form-control m-input"
                                                   value="{{ old('recipient') }}"
                                                   placeholder="">
                                        </div>

                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label">جریمه:</label>
                                            <input type="number" name="punishment"
                                                   value="{{ old('punishment') }}"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                        <div class="col-lg-4 m-form__group-sub">
                                            <label class="form-control-label">ملاحظات:</label>
                                            <input type="text" name="considerations"
                                                   value="{{ old('considerations') }}"
                                                   class="form-control m-input"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-8">
                                            <label class="form-control-label">ضمایم:</label>
                                            <div class="custom-file">
                                                <input type="file" multiple name="attachments[]"
                                                       class="custom-file-input">
                                                <label class="custom-file-label" for="customFile">برای انتخاب ضمایم،
                                                    اینجا
                                                    کلیک کنید!</label>
                                            </div>
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

@section('plugins')
    <script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
@endsection

@section('scripts')
    <script type="text/javascript">

        $('#students').select2();

        $('#save-button').click(function () {
            var form = $('#save-form');
            form.validate();
            if (form.valid())
                form.submit();
        });
    </script>
@endsection

