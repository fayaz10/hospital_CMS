@extends('layouts.app')


@section('sidebar')
    @include('config.partials.sidebar')
@endsection


@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">تنظیمات سیستم</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-forward"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">لست تنظیمات </span>
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
                        </div>
                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <!----><a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="{{ url('/admin/config/create') }}">
                                <span> <i class="la la-plus"></i> <span>ایجاد</span> </span> </a>
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table m-table m-table--head-separator-primary">
                    <thead class="table-inverse">
                    <tr>
                        <!-- <th>شماره</th> -->
                        <th>مشخصه</th>
                        <th>قیمت</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($configs as $key => $value)
                        <tr>
                            <td><a href="{{ url('/admin/config/' . $key) }}">{{ $key }}</a></td>
                            @php
                            $output = null;
                            if(is_array($value))
                                $output = implode(', ', array_map(
                                    $fun = function ($v, $k) { return sprintf("%s=>%s", $k, $v); },
                                    $value,
                                    array_keys($value)
                                ));
                            else
                                $output = $value;
                            @endphp
                            <td>{{ $output }}</td>
                            <td><a href="{{ url('/admin/config/' . $key . '/edit') }}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
