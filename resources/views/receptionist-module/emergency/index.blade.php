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
    <div class="m-portlet m-portlet--mobile">
        @permission('rec_doc_show')
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-8 col-lg-7">
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <a href="{{ route('emergency.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        @permission('rec_doc_create')
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('emergency.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        @endpermission
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('global.number')}}</th>
                        <th>{{__('global.reason')}}</th>
                        <th>{{__('reception.pat_name')}}</th>
                        <th>{{__('reception.pay_tax')}}</th>
                        <th>{{__('reception.amountOfPayament')}}
                        <th>{{__('reception.pay_discount')}}
                        <th>{{__('global.operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $item)
                    <tr>
                        <td>{{ ($list->currentPage() == 0 ? 1 :$list->currentPage() - 1) * $list ->perPage() + $key + 1}}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ $item->patient_id ? optional($item->patient)->name . ' (' . optional($item->patient)->record_no .')' : $item->patient_name }}</td>
                        <td>{{ $item->profit->taxes }} {{ $item->profit->currency->label_dr }} </td>
                        <td>{{ $item->profit->totalAmount }} {{ $item->profit->currency->label_dr }} </td>
                        <td>{{ $item->discount ? $item->discount . '%' : '-' }}</td>
                        <td>
                            <a href="{{ route('emergency.show', [$item->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            @permission('rec_doc_edit')
                            <a href="{{ route('emergency.edit', $item->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $list->links() }}
        </div>
        @endpermission
    </div>
</div>
@endsection
