@extends('layouts.app')


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
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"> {{__('global.dashboard')}}</span>
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
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('medicine-purchase.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('medicine-purchase.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.gol_cret1')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('pharmacist.med_number')}}</th>
                        <th>{{__('pharmacist.med_import')}}</th>
                        <th>{{__('pharmacist.med_purchase_date')}}</th>
                        <th> {{__('pharmacist.pre_medicine_quantity')}}</th>
                        <th> {{__('pharmacist.med_totalPrice')}}</th>
                        <th>{{__('pharmacist.med_operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $key => $purchase)
                    <tr>
                        <td>{{ ($purchases->currentPage() == 0 ? 1 :$purchases->currentPage() - 1) * $purchases ->perPage() + $key + 1}}</td>
                        <td>{{ $purchase->suppliers  }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ $purchase->medicines->count() }} {{__('pharmacist.pres_items')}}</td>
                        <!-- <td>{{ $purchase->spend ? $purchase->spend->amount : 0 }} {{ app()->getLocale() == 'en' && $purchase->spend ? $purchase->spend->currency->label_en : null }}</td> -->
                        <td>
                            @if ($purchase->spend)
                                {{ $purchase->spend->amount }} {{ app()->getLocale() == 'en' ? $purchase->spend->currency->label_en : $purchase->spend->currency->label_dr }}
                            @else
                                0 
                            @endif
                        </td>

                        <!-- <td>{{-- $purchase->spend ? $purchase->spend->amount : 0 }} {{ app()->getLocale() == 'en' && $purchase->spend ? $purchase->spend->currency->label_en : $purchase->spend->currency->label_dr --}}</td> -->
                        <!-- <td>{{-- $purchase->spend->payment_date --}}</td> -->
                        <td>
                            <a href="{{ route('medicine-purchase.show', [$purchase->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('medicine-purchase.edit', $purchase->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection