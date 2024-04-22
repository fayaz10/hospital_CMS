@extends('layouts.app')

@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                {{ __('reception.rec_modul') }}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{ __('reception.frst_page') }}</span>
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
                            <i class="flaticon-alert"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{ __('global.emergency') }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('visit.index') }}"
                        class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{ __('global.gol_back') }}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button"
                            class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{ __('global.gol_save') }}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('emergency.store') }}" id="save-form" enctype="multipart/form-data"
                class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                <div class="row">
                    <div class="col-md-12">
                        @include('errors.validation-errors')
                        <div class="m-form__section">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> <i
                                            class="text-danger">*</i>{{ __('global.reason') }}</label>
                                    <input type="text" value="{{ old('reason') }}" name="reason" required
                                        class="form-control m-input" placeholder="">
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">
                                        {{ __('pharmacist.pre_patientRecord') }}</label>
                                    <select class="form-control m-input" name="patient_id" id="patient">
                                    </select>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> <i
                                            class="text-danger">*</i>{{ __('reception.pat_name') }}</label>
                                    <input type="text" value="{{ old('patient_name') }}" name="patient_name" required
                                        class="form-control m-input" placeholder="">
                                </div>

                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">{{ __('pharmacist.pre_docName') }}</label>
                                    <select class="form-control m-input" name="doctor_id" onchange="selectDoctor(this)"
                                        id="doctor">
                                        <option value=""></option>
                                        @foreach(\App\Models\Receptionist\Doctor::all() as $doctor)
                                        <option value="{{ $doctor->id }}">
                                            {{ $doctor->name }} ({{ $doctor->specialist }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> <i
                                            class="text-danger">*</i>{{ __('reception.amountOfPayament') }}</label>
                                    <input type="number" value="{{ old('amount') }}" name="amount" required
                                        class="form-control m-input" id="amount" onchange="total()">
                                    <span class="m-form__help text-primary" id="total">{{ __('global.with_tax') }}
                                    </span>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> <i
                                            class="text-danger">*</i>{{ __('reception.docy_currency') }}</label>
                                    <select class="form-control m-input" name="currency_id">
                                        @foreach(\App\Models\FinanceModule\Currency::all() as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->label_dr }} ({{ $type->symbol }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                @permission('rec_vis_discount')
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">{{__('reception.pay_discount')}}</label>
                                    <select class="form-control m-input" name="discount" id="discount">
                                        <option value="">
                                        </option>
                                        <option value="10">
                                            10%
                                        </option>
                                        <option value="15">
                                            15%
                                        </option>
                                        <option value="20">
                                            20%
                                        </option>
                                        <option value="25">
                                            25%
                                        </option>
                                        <option value="30">
                                            30%
                                        </option>
                                        <option value="35">
                                            35%
                                        </option>
                                        <option value="40">
                                            40%
                                        </option>
                                        <option value="50">
                                            50%
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">{{__('reception.pay_cardNum')}}</label>
                                    <input type="number" value="{{ old('member_id') }}" name="member_id"
                                        class="form-control m-input newPatient" placeholder="">
                                </div>
                                @endpermission
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
    $(document).ready(function () {
        $('#patient').select2({
            placeholder: '{{ __('reception.rec_search') }}',
            minimumInputLength: 5,
            ajax: {
                url: "{{ route('patient.filter') }}",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function (term) {
                    return term;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.record_no + ' (' + item.name + ')',
                                slug: item.record_no,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    });

    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });
        
        form.submit();
    });

    function roundUp(num) {
        return Math.round(num * 10) / 10;
    }

    function total() {
        var tHolders = parseInt($('#amount').val());

        tHolders += roundUp((tHolders * 4) / 100);

        $('#total').html('{{ __("global.with_tax") }} ' + tHolders);
    }

</script>
@endsection
