@extends('layouts.app')

@section('sidebar')
    @include('receptionist-module.partials.sidebar')
@endsection

@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('reception.rec_modul')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
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
    <div class="m-portlet m-portlet--mobile" id="m_portlet_tools_3">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-search"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        {{__('global.filter')}} 
                        {{__('finance.sideIncomeList')}} 
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-angle-down"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-expand"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-close"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <form action="" id="save-form" class="m-form m-form--label-align-left m-form--state col-12">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('finance.incSection')}}</label>
                                <select class="form-control m-input multiple" name="source[]">
                                        @foreach($incomeSources as $source)
                                        <option value="{{ $source }}">
                                            {{ __('finance.'.strtolower(basename($source, '\\')))  }}
                                        </option>
                                        @endforeach
                                </select>                            
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">
                                    {{__('finance.paymentDate')}}
                                </label>
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <select name="payment_date_equation" class="form-control">
                                            <option value="=">{{__('reception.op_e')}}</option>
                                            <option value=">=">{{__('reception.op_eG')}}</option>
                                            <option value="<=">{{__('reception.op_eL')}}</option>
                                            <option value=">">{{__('reception.op_g')}}</option>
                                            <option value="<">{{__('reception.op_l')}}</option>
                                            <option value="<>">{{__('reception.op_nE')}}</option>
                                        </select>
                                    </div>
                                    <input type="date" value="" name="payment_date" class="form-control m-input"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">{{__('finance.paymentRecipient')}}</label>
                                <input type="text" value="" name="recipient" class="form-control m-input" placeholder="">
                            </div>
                            <div class="col-lg-6 m-form__group-sub mt-3">
                                <label class="form-control-label">
                                    {{__('reception.pat_regdate')}}
                                    {{__('reception.from')}}
                                </label>
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <select name="from_date_equation" class="form-control">
                                            <option value="=">{{__('reception.op_e')}}</option>
                                            <option value=">=">{{__('reception.op_eG')}}</option>
                                            <option value="<=">{{__('reception.op_eL')}}</option>
                                            <option value=">">{{__('reception.op_g')}}</option>
                                            <option value="<">{{__('reception.op_l')}}</option>
                                            <option value="<>">{{__('reception.op_nE')}}</option>
                                        </select>
                                    </div>
                                    <input type="date" value="" name="from_date" class="form-control m-input"
                                    placeholder="">
                                    <div class="input-group-append">
                                        <input type="time" name="from_time" class="form-control m-input"
                                                placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 m-form__group-sub mt-3">
                                <label class="form-control-label">
                                    {{__('reception.pat_regdate')}}
                                    {{__('reception.till')}}
                                </label>
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <select name="till_date_equation" class="form-control">
                                            <option value="=">{{__('reception.op_e')}}</option>
                                            <option value=">=">{{__('reception.op_eG')}}</option>
                                            <option value="<=">{{__('reception.op_eL')}}</option>
                                            <option value=">">{{__('reception.op_g')}}</option>
                                            <option value="<">{{__('reception.op_l')}}</option>
                                            <option value="<>">{{__('reception.op_nE')}}</option>
                                        </select>
                                    </div>
                                    <input type="date" name="till_date" class="form-control m-input"
                                        placeholder="">
                                        <div class="input-group-append">
                                            <input type="time" name="till_time" class="form-control m-input"
                                                placeholder="">
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-4 m-form__group-sub mt-3">
                                <label class="form-control-label">
                                    {{__('reception.amountOfPayament')}}
                                </label>
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend">
                                        <select name="amount_equation" class="form-control">
                                            <option value="=">{{__('reception.op_e')}}</option>
                                            <option value=">=">{{__('reception.op_eG')}}</option>
                                            <option value="<=">{{__('reception.op_eL')}}</option>
                                            <option value=">">{{__('reception.op_g')}}</option>
                                            <option value="<">{{__('reception.op_l')}}</option>
                                            <option value="<>">{{__('reception.op_nE')}}</option>
                                        </select>
                                    </div>
                                    <input type="number" value="" name="amount" class="form-control m-input"
                                        placeholder="">
                                </div>
                            </div>

                            
                            <div class="col-lg-4 m-form__group-sub mt-3">
                                <label class="form-control-label">{{__('pharmacist.med_register')}}</label>
                                <select class="form-control m-input multiple" name="registrar_id[]">
                                    @foreach(\App\User::all() as $user)
                                    <option value="{{ $user->id }}">
                                        {{ app()->isLocale('en') ? $user->name : $user->name_dr }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-lg-4 m-form__group-sub mt-3">
                                <label class="form-control-label">{{__('global.approveBy')}}</label>
                                <select class="form-control m-input multiple" name="approver_id[]">
                                    @foreach(\App\User::all() as $user)
                                    <option value="{{ $user->id }}">
                                        {{ app()->isLocale('en') ? $user->name : $user->name_dr }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-lg-4 m-form__group-sub mt-3">
                                <label class="form-control-label">{{__('admin.adm_state')}}</label>
                                <select class="form-control m-input multiple" name="is_approved[]">
                                    <option value="1">{{__('global.received')}}</option>
                                    <option value="0">{{__('global.pending')}}</option>
                                    
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="m-portlet__foot">
            <button type="submit" class="btn btn-primary" id="save-button">
                <i class="flaticon-search"></i>
                {{__('global.search2')}}
            </button>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile" id="resultPortlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-file"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        {{__('reception.searchResult')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-angle-down"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-expand"></i>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-close"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body" id="">
            <div class="m-widget29">
                <div class="m-widget_content">
                    <h3 class="m-widget_content-title">{{__('global.quickResult')}}</h3>
                    <div class="m-widget_content-items">
                        <div class="m-widget_content-item">
                            <span>{{__('global.totalRecord')}}</span>
                            <span class="m--font-accent" id="totalRecord">0</span>
                        </div>
                        <div class="m-widget_content-item">
                            <span>{{__('global.totalPaidAmount')}}</span>
                            <span class="m--font-brand" id="totalPayment">0</span>
                        </div>
                        <div class="m-widget_content-item">
                            <span>{{__('global.totalTaxAmount')}}</span>
                            <span id="totalTax">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <table class="table m-table m-table--head-separator-primary" id="bootstrap-table" data-show-export="true"
                data-show-print="true" data-pagination="true" data-show-columns="true">
                <thead>
                    <tr>
                        <!-- <th data-field="id" data-sortable="true">#</th> -->
                        <th data-field="no" data-sortable="true">#</th>
                        <th data-field="source" data-sortable="true">{{__('finance.incSection')}}</th>
                        <th data-field="payment_date" data-sortable="true">{{__('finance.paymentDate')}}</th>
                        <th data-field="recipient" data-sortable="true">{{__('finance.paymentRecipient')}}</th>
                        <th data-field="amount" data-sortable="true">{{__('finance.amount')}}</th>
                        <th data-field="taxes" data-sortable="true">{{__('reception.pay_tax')}}</th>
                        <th data-field="totalAmount" data-sortable="true">{{__('reception.amountOfPayament')}}</th>
                        <th data-field="registrar" data-sortable="true">{{__('pharmacist.med_register')}}</th>
                        <th data-field="status" data-sortable="true">{{__('admin.adm_state')}}</th>
                        <th data-field="approvedBy" data-sortable="true">{{__('global.approveBy')}}</th>
                        <th data-field="created_at" data-sortable="true">{{__('reception.pat_regdate')}}</th>
                        <th data-field="operation" data-printIgnore="true" >{{__('global.view')}}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script src="{{asset('js/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script src="{{asset('js/bootstrap-table/bootstrap-table-print.min.js')}}"></script>
<script src="{{asset('js/bootstrap-table/tableExport.min.js')}}"></script>
<script src="{{asset('js/bootstrap-table/bootstrap-table-export.min.js')}}"></script>
<script src="{{asset('js/bootstrap-table/locale/bootstrap-table-fa-IR.min.js')}}"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {

        $('.multiple').select2({
            multiple: true,
            tags: "true"
        });

        var portlet = new mPortlet("m_portlet_tools_3");
        new mPortlet("resultPortlet");

        var table = $('#bootstrap-table').bootstrapTable({
            exportTypes: ['excel', 'csv', 'txt'],
            locale: '{{ app()->isLocale("en") ? "en-US" : "fa-IR" }}'
        });

        $('.fixed-table-loading').remove();

        $('#save-form').on('submit', function (e) {
            e.preventDefault(); //prevent form from submitting
            var data = $("#save-form").serializeArray();

            mApp.block("#save-form", {
                overlayColor: "#000000",
                type: "loader",
                message: "{{ __('global.loading') }} ..."
            });
            //submit the form
            $.ajax({
                url: '{{ route("reports.index") }}',
                type: "GET",
                data: data,
                dataType: "json",
                success: function (response) {
                    data = response.data
                    output = [];
                    totalPayment = 0;
                    totalTax = 0;
                    data.forEach(function (arrayItem, i) {
                        output.push({
                            "no": ++i,
                            "source": arrayItem.name,
                            "payment_date": arrayItem.payment_date,
                            "recipient": arrayItem.recipient,
                            "amount": arrayItem.amount,
                            "taxes": arrayItem.taxes,
                            "totalAmount": arrayItem.totalAmount,
                            "registrar": arrayItem.registrar.name,
                            "status": arrayItem.is_approved == 1 ? "{{__('global.received')}}" : "{{__('global.pending')}}" ,
                            "approvedBy": arrayItem.approved_by ? arrayItem.approved_by.name : null,
                            "created_at": arrayItem.created_at,
                            "operation": "<a href='" + arrayItem.url + "'<i class='flaticon-eye'></i></a>"
                        });
                        
                        totalPayment += arrayItem.totalAmount;
                        totalTax += arrayItem.taxes;
                    });

                    //remove the loader
                    mApp.unblock('#save-form');

                    // minimize the search portlet
                    portlet.collapse();

                    table.bootstrapTable('load', output);
                    
                    // count the quick result part
                    $("#totalRecord").text(data.length);
                    $("#totalPayment").text(totalPayment);
                    $("#totalTax").text(totalTax);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(
                        'Something is going wrong.\nPlease call to iSys Software Solutions.'
                    );
                }
            });
        });
    });

    $('#save-button').click(function () {
        $('#save-form').submit();
    });

</script>
@endsection
