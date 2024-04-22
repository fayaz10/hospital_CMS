@extends('layouts.app')

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
            <div class="m-portlet__body">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-4 order-2 order-xl-1">
                        </div>
                        <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                            {{--<a href="{{ route('finance.fees.create', $course->id) }}"--}}
                            {{--class="btn btn-secondary">--}}
                            {{--<span>--}}
                            {{--<i class="flaticon-coins"></i> <span>پرداخت فیس</span> </span> </a>--}}
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                            <a href="{{ route('admission.add', $course->id) }}"
                               class="btn btn-secondary">
                                <span>
                                    <i class="la la-book"></i> <span>ثبت داخله</span> </span> </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>

                            <a href="{{ route('course.edit', $course->id) }}"
                               class="btn btn-secondary">
                                <span>
                                    <i class="la la-pencil"></i> <span>ویرایش</span> </span> </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                               href="{{ route('course.create') }}">
                                <span> <i class="la la-plus"></i> <span>ایجاد</span></span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 ">

                            <!--Student Information -->
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title">معلومات کورس (صنف)</h3>
                                </div>


                                <div class="row form-group m-form__group ">
                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>کورس
                                                (Unique): </u></label>
                                        <p><strong>{{ $course->name }}</strong></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>نام
                                                کورس (دری): </u></label>
                                        <p><strong>{{ $course->label_dr }}</strong></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>کورس
                                                (English): </u></label>
                                        <p><strong>{{ $course->label_en }}</strong></p>
                                    </div>
                                </div>
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading ">
                                        <h3 class="m-form__heading-title"> مضامین </h3>
                                    </div>
                                    <div class="row form-group m-form__group">
                                        @foreach($course->subjects as $key => $subject)
                                            <div class="col-lg-4">
                                                <label class="form-control-label"><u> مضمون {{ ++$key }}:</u></label>
                                                <p><strong>{{ $subject->name }}</strong></p>
                                                <p><strong>{{ $subject->label_dr }}</strong></p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title">فیس کورس (صنف)</h3>
                                </div>

                                {{--@foreach($course->fees as $fee)--}}
                                <div class="row form-group m-form__group ">
                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>دوره صنف:</u></label>
                                        <p><strong>{{ $course->fees->term }}</strong></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>مقدار فیس:</u></label>
                                        <p><strong>{{ $course->fees->amount }}</strong></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-control-label"><u>واحد پولی: </u></label>
                                        <p><strong>{{ $course->fees->currency->label_dr }}
                                                ({{ $course->fees->currency->symbol }})</strong></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-control-label"> <u>تاریخ شروع:</u></label>
                                        <p>
                                            <strong>{{ $course->fees->start_date }}</strong>
                                        </p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-control-label"> <u>تاریخ ختم:</u></label>
                                        <p>
                                            <strong>{{ $course->fees->end_date }}</strong>
                                        </p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-control-label"> <u>ملاحظات:</u></label>
                                        <p><strong>{{ $course->fees->considerations }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title">لیست شاگردان این صنف</h3>
                                </div>

                                <div class="m-widget4 m-widget4--progress">

                                    @forelse($course->students as $key => $student)
                                        <div class="m-widget4__item">
                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img src="{{ url('student_pic/photos/' . $student->photo)}}" alt="">
                                            </div>
                                            <div class="m-widget4__info">
															<span class="m-widget4__title">
																{{ $student->name_dr }} - {{ $student->father_name_dr }}
                                                                - {{ $student->last_name_dr }}
															</span>
                                                <br>
                                                <span class="m-widget4__sub">
																شماره سکوک - {{ $student->tazkira_id }}
															</span>
                                            </div>

                                            <div class="m-widget4__ext pl-2 pr-2">
                                                @if($fee = $student->paidFees($course->id, true, true))
                                                    <span class="m-widget6__text">
                                                        <span class="m-badge {{ $fee->valid_status ? 'm-badge--primary' : 'm-badge--danger' }} m-badge--wide">{{ $fee->valid_duration }}
                                                            روز اعتبـــــــــــــــار</span>
                                                        {{--                                                        <span class="{{ $fee->valid_status ? 'bg-primary' : 'bg-danger' }}"> روز {{ $fee->valid_duration }} مدت اعتبار </span>--}}
                                                    </span>
                                                @else
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge  m-badge--wide">پرداخــــــــت نشده هنوز</span>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="m-widget4__ext">
                                                @if($student->pivot->discount)
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--warning m-badge--wide">{{ $student->pivot->discount . '%' }}
                                                            تخفیف </span>
                                                    </span>
                                                @else
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--light m-badge--wide">تخفیف ندارد</span>
                                                    </span>
                                                @endif
                                            </div>

                                            @php
                                                $percent = ceil($student->paidAmountInPercentage($course->id, $course));
                                            @endphp
                                            <div class="m-widget4__progress">
                                                <div class="m-widget4__progress-wrapper">
                                                    <span class="m-widget17__progress-number">
                                                        % {{ $percent }}
                                                    </span>
                                                    <span class="m-widget17__progress-label">مقدار پرداخت شده</span>
                                                    <div class="progress m-progress--sm" style="display:-webkit-box">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{ $percent }}%;"
                                                             aria-valuenow="{{ $percent }}"
                                                             aria-valuemin="0" aria-valuemax="{{ $percent }}"></div>
                                                        @if($student->pivot->discount)
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                 style="width: {{ $student->pivot->discount }}%;"
                                                                 aria-valuenow="{{$student->pivot->discount}}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="{{ $student->pivot->discount }}"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget4__ext">
                                                <a href="{{ route('finance.fees.create', [$course->id, $student->id]) }}"
                                                   class="m-btn m-btn--pill btn btn-sm btn-secondary">پرداخت</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="m-widget4__item">
                                            <p>هنوز شاگردی ثبت داخله نشده است</p>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

