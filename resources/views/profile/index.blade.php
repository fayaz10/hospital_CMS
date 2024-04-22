@extends('layouts.app')

@section('content')

<div class="m-content">

    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
            @include('errors.alert')
            @include('errors.validation-errors')
            <div class="row">
                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">پروفایل</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#messages" data-toggle="tab" class="nav-link">تبدیل رمز</a>
                        </li>
                        <li class="nav-item">
                            <a href="" data-target="#edit" data-toggle="tab" class="nav-link">ویرایش</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h5 class="mb-3">پروفایل کاربر</h5>
                            <div class="row">
                                <div class="form-group m-form__group">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> اسم کاربر </u></label>
                                        <p><strong>{{ $user->name_dr }} "{{ $user->name }}"</strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> ایمیل کاربر </u></label>
                                        <p><strong>{{ $user->email }}</strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> حالت کاربر </u></label>
                                        <p><strong>{{ $user->status ? 'فعال' : 'غیر فعال' }} </strong></p>
                                    </div>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <label class="form-control-label"><u> راجستر کننده </u></label>
                                        <p><strong>{{ $user->registrar->name }}-> {{ $user->registrar->email }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                        <div class="tab-pane" id="messages">
                            <form role="form" method="post"
                                action="{{ route('profile.change', [encrypt(auth()->id())]) }}">
                                @csrf()
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">رمز عبور</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="old_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">رمز جدید</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">تکرار رمز</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="تبدیل رمز">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="edit">
                            <form role="form" method="post"
                                enctype="multipart/form-data" 
                                action="{{ route('profile.update', [encrypt(auth()->id())]) }}">
                                @csrf()
                                @method('put')
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">اسم کاربر(انگلیسی)</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">اسم کاربر (دری)</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="name_dr" type="text" value="{{ $user->name_dr }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">ایمیل آدرس</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">انتخاب عکس</label>
                                    <div class="col-lg-9">

                                        <div class="custom-file">
                                            <input type="file" name="img_path" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="ذخیره">
                                        <input type="reset" class="btn btn-secondary" value="کنسل">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-1 text-center">
                    <img src="{{ file_exists(auth()->user()->img_path) ? asset(auth()->user()->img_path) : url('assets/app/media/img/users/user4.jpg') }}"
                        class="mx-auto img-fluid img-circle d-block" alt="avatar">
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
