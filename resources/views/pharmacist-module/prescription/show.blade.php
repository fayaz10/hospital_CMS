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
                        <span class="m-nav__link-text"> {{__('global.gol_fpage')}}</span>
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
                    <div class="col-xl-4 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('prescription.refund', [$prescription->id]) }}" class="btn btn-warning"
                            onclick="return confirm('{{ __('global.sure2refund') }}') ? confirm('{{ __('global.irreversable') }}')  : false;">
                            <span> <i class="la la-refresh"></i> <span>{{__('global.refundAll')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('prescription.print', [$prescription->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-print"></i> <span>{{__('global.print')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('prescription.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('prescription.edit', [$prescription->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span>{{__('global.gol_edit')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="{{ route('prescription.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            @include('errors.alert')
            @include('errors.validation-errors')
            <hr>
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title">{{__('pharmacist.pre_presInfo')}}</h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-3">
                                    <label class="form-control-label">{{__('reception.vis_patent')}}</label>
                                    <p><strong>{{ $prescription->patient->name }}</strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('reception.vis_record')}}</label>
                                    <p><strong>{{ $prescription->patient->record_no }}</strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('reception.vis_doctors')}}</label>
                                    <p><strong>{{ $prescription->doctor->name }}
                                            ({{ $prescription->doctor->specialist }})</strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('global.issue_date')}} </label>
                                    <p><strong>{{ $prescription->date }}</strong></p>
                                </div>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_netIncome')}}</label>
                                    <p><strong>
                                            {{ $prescription->profit->amount }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_taxes')}}</label>
                                    <p><strong>
                                            {{ $prescription->profit->taxes }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_totalPayment')}}</label>
                                    <p><strong>
                                            {{ $prescription->profit->totalAmount }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.med_register')}}</label>
                                    <p><strong>
                                            {{ app()->isLocale('en') ? $prescription->profit->registrar->name : $prescription->profit->registrar->name_dr }}
                                        </strong></p>
                                </div>
                            </div>

                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title"> {{__('pharmacist.med_medInfoPu')}}</h3>
                                </div>
                            </div>

                            <table class="table">
                                <thead class="thead-inverse">
                                    <tr class="h5">
                                        <th> {{__('pharmacist.med_number')}}</th>
                                        <th> {{__('pharmacist.med_name')}}</th>
                                        <th> {{__('pharmacist.med_milligram')}}</th>
                                        <th> {{__('pharmacist.med_type')}}</th>
                                        <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                                        <th> {{__('pharmacist.med_price')}}</th>
                                        <th> {{__('pharmacist.med_totalPrice')}}</th>
                                        <th>
                                            <!-- <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                data-target="#m_modal_3">
                                                <i class="flaticon-plus"></i>
                                            </button> -->
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prescription->medicines as $key => $medicine)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $medicine->name  }}</td>
                                        <td>{{ $medicine->milligram }}</td>
                                        <td>{{ app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr }}
                                        </td>
                                        <td>
                                            {{ $medicine->pivot->quantity }}
                                            {{ app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr }}
                                        </td>
                                        <td>
                                            {{ $medicine->pivot->unit_price }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </td>
                                        <td>
                                            {{ ($medicine->pivot->quantity * $medicine->pivot->unit_price) }}
                                            {{ app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr }}
                                        </td>
                                        <td>
                                            <!-- <button class="btn btn-sm"
                                                onclick="event.preventDefault();editPurchaseItem('{{$medicine->pivot->id}}')">
                                                <i class="flaticon-edit-1"></i>
                                            </button>
                                            &nbsp;
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="event.preventDefault();deleteTestCompletion('{{$medicine->pivot->id}}')">
                                                <i class="flaticon-delete-1"></i>
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('lab.lab_expEditTestedExp')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    @method('put')
                    <div class="form-group">
                        <label for="experimentor" class="form-control-label">{{__('pharmacist.med_info')}}</label>
                        <span class="form-control">
                            <strong id="medicine">&nbsp;</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="results"
                            class="form-control-label">{{__('pharmacist.pre_medicine_quantity')}}</label>
                        <input type="number" value="" name="quantity" id="quantity" class="form-control m-input"
                            placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('global.gol_save2')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_modal_3" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('pharmacist.med_AddnewMed')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('stock-out.store') }}" id="add-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                    <div class="form-group m-form__group">
                        <label for="experimentor" class="form-control-label">{{__('pharmacist.med_name')}}</label>
                        <select class="form-control m-input" style="width: 100%" id="newTestAdd"
                            name="medicine_id"></select>
                    </div>
                    <div class="form-group">
                        <label for="results"
                            class="form-control-label">{{__('pharmacist.pre_medicine_quantity')}}</label>
                        <input type="number" value="" name="quantity" id="quantity" class="form-control m-input"
                            placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('global.gol_save2')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_modal_2" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('pharmacist.purDeleteItem')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('purchase-list.destroy', [null]) }}" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    @method('delete')
                    <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                    <p>
                        {{__('pharmacist.purDeleteItemMessage')}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('global.delete')}}</button>
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
    $('#newTestAdd').select2({
        // theme: "bootstrap",
        placeholder: "Required",
        minimumInputLength: 4,
        ajax: {
            url: "{{ route('medicine.filter.ajax') }}",
            dataType: 'json',
            type: "get",
            data: function (term) {
                return {
                    name: term.term
                };
            },
            processResults: function (data) {
                return {
                    // results: data
                    results: $.map(data, function (item) {
                        return {
                            text: item.name + ' (' + item.milligram + ') mg',
                            id: item.id
                        }
                    })
                };
            },
        }
    });

    function editPurchaseItem(id) {

        $('#m_modal_4').modal('toggle');

        mApp.block("#m_modal_4 .modal-body", {
            overlayColor: "#000000",
            type: "loader",
            message: "Loading ..."
        });

        $.ajax({
            type: 'GET',
            url: '{{ route("stock-out.show", [null]) }}' + '/' + id,
            dataType: 'json',
            success: function (data) {
                mApp.unblock('.modal-body');
                $('#m_modal_4 #medicine').text(data.medicine.name + ' (' + data.medicine.milligram + ')mg' +
                    ' "' + data.medicine.company + '"');
                $('#m_modal_4 #quantity').val(data.quantity);

                $('#m_modal_4 #save-form').attr('action', '{{ route("stock-out.update", [null]) }}' + '/' +
                    id);
                // var form = $('#m_modal_4 #save-form');
                // form.attr('action', form.attr('action') + '/' + id);

            },
            error: function (jqXHR, exception) {
                mApp.block("#m_modal_4 .modal-body", {
                    overlayColor: "#000000",
                    type: "loader",
                    message: "Something bad happened to server couldn't load data ..."
                });
            }
        });
    }

    function deleteTestCompletion(id) {
        $('#m_modal_2').modal('toggle');
        $('#m_modal_2 #save-form').attr('action', '{{ route("stock-out.destroy", [null]) }}' + '/' + id);
    }

</script>

@endsection
