@extends('layouts.app')


@section('sidebar')
@include('finance-module.partials.sidebar')
@endsection


@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('finance.finance-module')}}</h3>
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
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-6">
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('expense.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('pharmacist.med_number')}}</th>
                        <th> {{__('finance.cause')}}</th>
                        <th> {{__('finance.total_paid')}}</th>
                        <th> {{__('finance.paymentDate')}}</th>
                        <th> {{__('pharmacist.med_payment')}}</th>
                        <th> {{__('lab.lab_expCreatedAt')}}</th>
                        <th> {{__('global.glo_hou')}}</th>
                        <th>{{__('pharmacist.med_operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $key => $expense)
                    <tr>
                        <td>{{ ($expenses->currentPage() == 0 ? 1 :$expenses->currentPage() - 1) * $expenses ->perPage() + $key + 1}}</td>
                        <td>{{ __('finance.'.strtolower(basename($expense->spendable_type, '\\')))  }}</td>
                        <td>
                            {{ $expense->amount }}
                            {{ app()->getLocale() == 'en' ? $expense->currency->label_en : $expense->currency->label_dr }}
                        </td>
                        <td>{{ $expense->payment_date }}</td>
                        <td>{{ $expense->remitter }}</td>
                        <td>{{ $expense->created_at->format('Y-m-d') }}</td>
                        <td>{{ $expense->created_at->format('g:i A') }}</td>

                        <td>
                            <a href="{{ route('expense.show', [$expense->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="disabled" href="#">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection
