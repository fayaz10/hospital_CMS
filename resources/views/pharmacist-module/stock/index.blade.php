@extends('layouts.app')


@section('sidebar')
    @include('pharmacist-module.partials.sidebar')
@endsection

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">مادیول فارمسی (دوا خانه)</h3>
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

                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-6 order-2 order-xl-1">
                            <div class="col-md-6">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--air" placeholder="جستجو ...">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="{{ route('doctor.create') }}">
                                <span> <i class="la la-plus"></i> <span>ایجاد</span> 
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
                        <th>شماره</th>
                        <th>اسم دوا</th>
                        <th>کمپنی سازنده</th>
                        <th>نوع دوا</th>
                        <th>مقدار موجودی</th>
                        <th>قیمت واحد</th>
                        <th>قیمت مجموع</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stock as $key => $item)
                        <tr>
                            <td>{{ ($stock->currentPage() == 0 ? 1 : $stock->currentPage() - 1) * $stock ->perPage() + $key + 1}}</td>
                            <td>{{ $item->name  }}</td>
                            <td>{{ $item->company }}</td>
                            <td>{{ app()->getLocale() == 'en' ? $item->type->label_en : $item->type->label_dr }}</td>
                            <td>{{ $item->store->quantity }} {{ app()->getLocale() == 'en' ? $item->unit->label_en : $item->unit->label_dr }} </td>
                            <td>{{ $item->store->unit_price }} {{ app()->getLocale() == 'en' ? $item->store->currency->label_en : $item->store->currency->label_dr }} </td>
                            <td>{{ $item->store->unit_price * $item->store->quantity}} {{ app()->getLocale() == 'en' ? $item->store->currency->label_en : $item->store->currency->label_dr }} </td>
                            <td>
                                <a href="{{-- route('medicine-stock.show', [$item->id]) --}}">
                                    <i class="flaticon-eye"></i> 
                                </a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{-- route('medicine-stock.edit', $item->id) --}}"> 
                                    <i class="flaticon-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $stock->links() }}
            </div>
        </div>
    </div>
@endsection

