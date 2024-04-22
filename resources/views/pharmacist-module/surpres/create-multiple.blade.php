@extends('layouts.app')

@section('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
@endsection

@section('sidebar')
@include('pharmacist-module.partials.sidebar')
@endsection


@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> {{__('pharmacist.med_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href=" {{route('medicine.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('global.gol_fpageMed')}}</span>
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
                            {{ __('global.gol_create_multiple') }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('medicine.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
            <form action="{{ route('medicine.store') . '?multiple' }}" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                <!--begin: Form Body -->
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"> {{__('pharmacist.med_newMed')}}</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <table class="table m-table m-table--head-separator-primary">
                                        <thead class="table-inverse">
                                            <tr>
                                                <th>{{__('pharmacist.med_name')}}</th>
                                                <th>{{__('pharmacist.med_milligram')}}</th>
                                                <th>{{__('pharmacist.med_company')}}</th>
                                                <th> 48% {{__('pharmacist.med_type')}}</th>
                                                <th>{{__('pharmacist.med_unit')}}</th>
                                                <th>
                                                    <button class="btn btn-primary" onclick="addNew(event)">
                                                        <i class="flaticon-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td><select required style="min-width:200px" class="ownerInput" name="items[0][name]"></select></td>
                                                <td><input type="number" required class="form-control" name="items[0][milligram]"></td>
                                                <td><input type="text" required class="form-control" name="items[0][company]"></td>
                                                <td>
                                                    <select class="form-control m-input" name="type_id">
                                                        @foreach(\App\Models\Pharmacist\MedicineType::all() as $type)
                                                        <option value="{{ $type->id }}" {{ old("type_id") == $type->id ? "selected" : "" }}>
                                                            {{ app()->isLocale("en") ? $type->label_en : $type->label_dr }} ({{ $type->name }})
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control m-input" name="unit_id">
                                                        @foreach(\App\Models\Pharmacist\Unit::all() as $unit)
                                                        <option value="{{ $unit->id }}" {{ old("unit_id") == $unit->id ? "selected" : "" }}> {{ app()->isLocale("en") ? $unit->label_en : $unit->label_dr }} ({{ $type->name }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                <button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>
                                                </tr>
                                            </tr>

                                        </tbody>
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

@section('plugins')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
@endsection

@section('scripts')

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });


    $(document).ready(function() {
        applySelect2();

    });

    function applySelect2() {
        $('.ownerInput').select2({
            // theme: "bootstrap",
            placeholder: "Required",
            minimumInputLength: 4,
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
                                text: item.name + ' (' + item.milligram + ') mg',
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
            '<td><select required style="width:200px" class="ownerInput" name="items[' + index + '][name]"></select></td>' +
            '<td><input type="number" required class="form-control" name="items[' + index + '][milligram]"></td>' +
            '<td><input type="text" required class="form-control" name="items[' + index + '][company]"></td>' +
            '<td> <select class="form-control m-input" name="items[' + index + '][type_id]"> @foreach(\App\Models\Pharmacist\MedicineType::all() as $type) <option value="{{$type->id}}"{{old("type_id")==$type->id ? "selected" : ""}}>{{app()->isLocale("en") ? $type->label_en : $type->label_dr}}({{$type->name}}) </option> @endforeach </select> </td>' +
            '<td> <select class="form-control m-input" name="items[' + index + '][unit_id]"> @foreach(\App\Models\Pharmacist\Unit::all() as $unit) <option value="{{$unit->id}}"{{old("unit_id")==$unit->id ? "selected" : ""}}>{{app()->isLocale("en") ? $unit->label_en : $unit->label_dr}}({{$type->name}})</option> @endforeach </select> </td>' ;
            // '<td>' +
            // '<button class="btn btn-info" onclick="event.preventDefault();pasteInfo(this)" '+
            //     // 'data-toggle="m-tooltip" '+
            //     // 'data-html="true" '+
            //     // 'data-original-title="<b>Panadol Charck 345 mg</b><br/>Stock Available = 908<br/>Unit price = 456<br/>Unit = Bottol<br/>Type = Syrup<br/>"
            //     '>'+
            //     '<i class="flaticon-questions-circular-button"></i>'+
            // '</button>'+
            // '</td>';

        var inputsEnd =
            '<td>' +
            '<button class="btn btn-danger" onclick="remove(this, event)"><i class="flaticon-delete-1"></i></button>' +
            '</tr>';

        $('#tbody').append(inputsStart + inputsEnd);
        applySelect2();

    }
    function uuid() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    };

    function remove(obj, e) {
        e.preventDefault();
        console.log($(obj).parents('tr'));
        $(obj).parents('tr').remove();
    }
</script>
@endsection