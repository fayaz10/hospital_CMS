@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

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
                    <a href="{{route('visit.index')}}" class="m-nav__link">
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
                            {{__('lab.lab_expEdit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('experiment.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{__('global.gol_save')}}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('experiment.update', [$experiment->id]) }}" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                @method('put')
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{__('lab.lab_expInf')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> {{ __('pharmacist.pre_patientRecord') }}</label>
                                        <select class="form-control m-input" required name="patient_id" id="patient">
                                            <option value="{{ $experiment->patient->id }}">
                                                {{ $experiment->patient->record_no }} ({{ $experiment->patient->name }})
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-5 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> {{ __('pharmacist.pre_docName') }}</label>

                                        <select class="form-control m-input" name="doctor_id" id="doctor">
                                            <option value=""></option>
                                            @foreach(\App\Models\Receptionist\Doctor::all() as $doctor)
                                            <option value="{{ $doctor->id }}" {{ $doctor->id == $experiment->doctor_id ? 'selected' : '' }}>
                                                {{ $doctor->name }} ({{ $doctor->specialist }})
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-lg-3 m-form__group-sub">
                                        <label class="form-control-label">{{ __('lab.lab_expStatusCompletion') }}</label>
                                        <select class="form-control m-input" name="status" id="status">
                                            <option value="">
                                            </option>

                                            <option value="1" {{ $experiment->status == true ? 'selected' : '' }}>
                                                {{ __('lab.lab_expStatusCompleted') }}
                                            </option>

                                            <option value="0" {{ $experiment->status == false ? 'selected' : '' }}>
                                                {{ __('lab.lab_expStatusNotCompleted') }}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{__('lab.lab_expTestsDone')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th>{{__('lab.lab_test')}}  </th>
                                                <th>{{__('pharmacist.med_price')}}</th>
                                                <th>&nbsp;</th>
                                                <th>
                                                    <button class="btn btn-primary" onclick="addNew(event)">
                                                        <i class="flaticon-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            @foreach($experiment->tests as $test)
                                                <tr>
                                                    <td style="width:60%"><select required style="width:100%" class="form-control" name="oldItems[{{$test->id}}][test_id]">
                                                        <option value="{{ $test->id }}" selected>{{$test->name}}</option>
                                                    </select></td>
                                                    <td style="width:40%"><span class="form-control total" id="unit-price">{{$test->price}}</span></td>
                                                    <td>
                                                        <button class="btn btn-info" onclick="event.preventDefault();pasteInfo(this)">
                                                            <i class="flaticon-questions-circular-button"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" onclick="remove(this, event)">
                                                            <i class="flaticon-delete-1"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><strong class="text-primary"><u><span id="total"></span></u></strong</td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>


<script type="text/javascript">
    $('#save-button').click(function () {
        submitBtn = this;
        var form = $('#save-form');
        form.validate();

        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });

        if (form.valid())
            form.submit();
    });


    $(document).ready(function() {
        total();
        $('#patient').select2({
            placeholder: '{{__("reception.rec_search")}}',
            minimumInputLength: 5,
            ajax: {
                url: "{{ route('patient.filter') }}",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
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

        applySelect2();

    });

    function applySelect2() {
        $('.ownerInput').select2({
            // theme: "bootstrap",
            placeholder: "Required",
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('experiment.filter.ajax') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return {
                        name: term.term
                    };
                },
                processResults: function(data) {
                    return {
                        // results: data
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    }

    function addNew(e) {
        var index = uuid();
        e.preventDefault();
        var inputsStart = '<tr>' +
            '<td style="width:60%"><select required style="width:100%" class="ownerInput" onchange="pasteInfo(this, true);" name="items[' + index + '][test_id]"></select></td>' +
            '<td style="width:40%"><span class="form-control total" id="unit-price">&nbsp;</span></td>' +
            '<td>' +
            '<button class="btn btn-info" onclick="event.preventDefault();pasteInfo(this)">' +
            '<i class="flaticon-questions-circular-button"></i>' +
            '</button>' +
            '</td>';

        var inputsEnd =
            '<td>' +
            '<button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>' +
            '</tr>'

        $('#tbody').append(inputsStart + inputsEnd);
        applySelect2();

    }

    function pasteInfo(param, medicineChange) {
        var medicineId = $(param).closest('tr').find('select').val();
        if (!medicineId && !medicineChange) {
            alert('Please select a medicine to see it\'s information.');
            return false;
        }

        $('#m_info').modal('toggle');

        mApp.block(".modal-body", {
            overlayColor: "#000000",
            type: "loader",
            message: "Loading ..."
        });

        $.ajax({
            type: 'GET',
            url: '{{ route("test.show", [null]) }}' + '/' + medicineId,
            dataType: 'json',
            success: function(data) {
                mApp.unblock('.modal-body');
                $('#m_info #name').text(data.name );
                $('#m_info #price').text(data.price + ' ' + data.currency.label_en);
                $('#m_info #company').html(data.label_en + '<br>' + data.label_dr);
                $('#m_info #quantity').html(data.description_en + '<br>' + data.description_dr);
                $(param).closest('tr').find('#unit-price').text(data.price);
                total();
            }
        });
    }

    function uuid() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    };

    function remove(obj, e) {
        e.preventDefault();
        $(obj).parents('tr').remove();
        total();
    }

    function roundUp(num, precision) {
        // precision = Math.pow(10, precision)
        // return Math.ceil(num * precision) / precision
        return Math.round(num * 10) / 10;
    }

    function changeStatus(param) {
        var status = $(param).is(':checked');
        $('#doctor').prop("disabled", status);
    }
    
    function total()
    {
        var tHolders = $('.total');
        var total= 0;
        tHolders.each(function(key, item){
            total += +$(item).text();
        });
        tax = roundUp((total * 4) / 100);
        $('#total').html(total + tax);
    }
</script>
@endsection