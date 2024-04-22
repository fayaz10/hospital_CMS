@extends('layouts.app')


@section('sidebar')
    @include('student-module.partials.sidebar')
@endsection


@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">مادیول شاگردان</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-forward"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">لست شاگردان </span>
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
                                      href="{{ route('student.create') }}">
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
                        <th>سکوک</th>
                        <th>اسم</th>
                        <th>ولد</th>
                        <th>تخلص</th>
                        <th> عکس</th>
                        <th>تاریخ تولد</th>
                        <th>&nbsp;عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $student->tazkira_id }}</td>
                            <td>{{ $student->name_dr }}</td>
                            <td>{{ $student->father_name_dr }}</td>
                            <td>{{ $student->last_name_dr }}</td>

                            <td><img src="{{asset('student_pic/photos/'.$student->photo)}}"
                                     style="width:50px;height:50px;"/></td>

                            <td>{{ $student->dob_dr }}</td>
                            <td><a href="{{ route('student.edit', $student->id) }}"> <i class="flaticon-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{ route('student.show', $student->id) }}"> <i class="flaticon-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" data-toggle="modal" data-target="#m_modal_1"> <i
                                            class="flaticon-delete-2"></i></a></td>


                            <form method="post" style="display:none" action="{{route('student.destroy',$student->id)}}"
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
