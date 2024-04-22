@extends('layouts.app')

@section('styles')
@endsection

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
                            {{__('global.gol_edit')}} {{__('pharmacist.pre_presInfo')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{__('global.gol_save2')}}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('prescription.update', $prescription->id) }}" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                @method('PUT')
                <!--begin: Form Body --> 

                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 ">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{__('pharmacist.pre_presInfo')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> {{__('pharmacist.pre_patientRecord')}}</label>
                                        <select class="form-control m-input" name="patient_id" id="patient">
                                            <option value="{{ $prescription->patient->id }}">
                                                ({{ $prescription->patient->name }}) {{ $prescription->patient->record_no }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-8 m-form__group-sub">
                                        <label class="form-control-label">{{__('pharmacist.pre_docName')}}</label>
                                        
                                        <select class="form-control m-input" name="doctor_id" id="doctor">
                                            <option value=""></option>
                                                @foreach(\App\Models\Receptionist\Doctor::all() as $doctor)
                                                    <option value="{{ $doctor->id }}" {{ $prescription->doctor_id == $doctor->id ? 'selected' : null }}>
                                                        {{ $doctor->name }} ({{ $doctor->specialist }})
                                                    </option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4 m-form__group-sub">
                                        <label class="form-control-label"><span class="text-danger">* </span> {{__('pharmacist.pre_issueDate')}}</label>
                                        <input type="date" required value="{{ $prescription->date }}" name="date" required class="form-control m-input" placeholder="">
                                    </div>

                                    <div class="col-lg-8 m-form__group-sub">
                                        <label class="form-control-label">{{__('pharmacist.pre_diagnosis')}}</label>
                                        <textarea name="diagnosis" class="form-control">{{ $prescription->diagnosis }}</textarea>
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">{{__('pharmacist.pre_prescriptedMedicines')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th>{{__('pharmacist.med_name')}}</th>
                                                <th>{{__('pharmacist.med_quantity')}}</th>
                                                <th>{{__('pharmacist.med_price')}}</th>
                                                <th>{{__('pharmacist.med_totalPrice')}}</th>
                                                <th>&nbsp;</th>
                                                <th>
                                                    <button class="btn btn-primary" onclick="addNew(event)">
                                                        <i class="flaticon-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            @foreach($prescription->medicines as $medicine)
                                            <tr>
                                                <td><select required style="min-width:300px" class="form-control" name="oldItems[{{$medicine->id}}][medicine_id]">
                                                    <option value="{{$medicine->id}}"> {{$medicine->name}} ({{$medicine->milligram}} mg) </option>
                                                </select></td>
                                                <td><input type="number" 
                                                        id="quantity" 
                                                        onchange="calculateBU(this)" 
                                                        value="{{$medicine->pivot->quantity}}" required 
                                                        class="form-control" name="oldItems[{{$medicine->id}}][quantity]">
                                                    </td>
                                                <td><input type="number" readonly value="{{$medicine->pivot->unit_price}}" class="form-control" id="unit-price"></td>
                                                <td><span class="form-control total" id="total-price">
                                                    {{$medicine->pivot->quantity * $medicine->pivot->unit_price}}
                                                </span></td>

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
                                                <td></td>
                                                <td></td>
                                                <td colspan="3"><strong class="text-primary"><u><span id="total"></span></u></strong></td>
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

<div class="modal fade" id="m_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('pharmacist.med_info')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">{{__('pharmacist.med_name')}}</label><br>
                    <span><strong id="name">{{ __('pharmacist.pre_netUnavailable') }}</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">{{__('pharmacist.med_company')}}</label><br>
                    <span><strong id="company">{{ __('pharmacist.pre_netUnavailable') }}</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">{{__('pharmacist.med_excist')}}</label><br>
                    <span><strong id="quantity">{{ __('pharmacist.pre_netUnavailable') }} </strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">{{__('pharmacist.med_price')}}</label><br>
                    <span><strong id="price">{{ __('pharmacist.pre_netUnavailable') }}</strong></span>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">{{__('pharmacist.med_type')}}</label><br>
                    <span><strong id="type">{{ __('pharmacist.pre_netUnavailable') }}</strong></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pharmacist.pre_thanks') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
@endsection

@section('scripts')

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        submitBtn = this
        form.on('submit', function(e) {
            $(submitBtn).prop("disabled",true);
        });
        form.validate();
        if (form.valid())
            form.submit();
    });


    $(document).ready(function() {
        total();
        $('#patient').select2({
            placeholder: '{{__('reception.rec_search')}}',
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
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('medicine.filter.ajax') }}",
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
                                text: item.name + ' (' + item.milligram + ' mg) (' + item.type.label_en + ')',
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
            '<td><select required style="min-width:300px" class="ownerInput" onchange="pasteInfo(this, true);" name="items[' + index + '][medicine_id]"></select></td>' +
            '<td><input type="number" id="quantity" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][quantity]"></td>' +
            // '<td><input type="number" id="total-price" required class="form-control" onchange="calculateBU(this)" name="items[' + index + '][total_price]"></td>' +
            '<td><input type="number" readonly class="form-control" id="unit-price"></td>' +
            '<td><span class="form-control total" id="total-price">&nbsp;&nbsp;</span></td>' +
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

    function uuid() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    };

    function remove(obj, e) {
        e.preventDefault();
        $(obj).parents('tr').remove();
        total();
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
            url: '{{ route("medicine.show", [null]) }}' + '/' + medicineId,
            dataType: 'json',
            success: function(data) {
                mApp.unblock('.modal-body');
                $('#m_info #name').text(data.name + ' (' + data.milligram + ') mg');
                $('#m_info #company').text(data.company);
                $('#m_info #quantity').text(data.store.quantity + ' ' + ('{{app()->isLocale("en")}}' ? data.type.label_en : data.type.label_dr));
                $('#m_info #price').text(data.store.unit_price + ' ' + ('{{app()->isLocale("en")}}' ? data.store.currency.label_en : data.store.currency.label_dr));
                $('#m_info #type').text(('{{app()->isLocale("en")}}' ? data.type.label_en : data.type.label_dr));
                $(param).closest('tr').find('#unit-price').val(data.store.unit_price);
            }
        });
    }

    function calculateBU(param) {
        param = $(param);
        
        unitPrice = param.closest('tr').find('#unit-price');
        totalPrice = param.closest('tr').find('#total-price');

        if (!unitPrice.val())
            return false;
        
        totalPrice.text(roundUp(unitPrice.val() * param.val()));
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