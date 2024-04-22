@extends('layouts.app')


@section('sidebar')
    @include('course-module.partials.sidebar')
@endsection

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">مادیول کورس ها و مضامین</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-forward"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">لست مضامین </span>
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
                                      href="{{ route('subject.create') }}">
                                <span> <i class="la la-plus"></i> <span>ایجاد</span> </span> </a>
                            {{--<div class="m-separator m-separator--dashed d-xl-none"></div>--}}
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table m-table m-table--head-separator-primary">
                    <thead class="table-inverse">
                    <tr>
                        <th>شماره</th>
                        <th>مضمون</th>
                        <th>نام (دری)</th>
                        <th>نام (English)</th>
                        <th>&nbsp;عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($subjects as $subject)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->label_dr }}</td>
                            <td>{{ $subject->label_en }}</td>
                            <td><a href="#" data-toggle="modal" data-target="#m_modal_1"><i class="flaticon-delete-2"
                                                                                            style="color:red"></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="{{ route('subject.edit', $subject->id) }}"> <i class="flaticon-edit"></i></a>
                            </td>

                            <form method="post" style="display:none" action="{{route('subject.destroy',$subject->id)}}"
                                  id="form-delete-{{$loop->index}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                            </form>

                            <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">تایید حذف دیتا </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>آیا مطمین هستید که دیتا مورد نظر را حذف کنید؟ </p>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <button type="button" class="btn btn-danger" onclick="
                                                    document.getElementById('form-delete-{{$loop->index}}').submit();
                                                    "> بلی
                                            </button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">نخیر
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
