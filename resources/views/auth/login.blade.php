{{-- <!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>iSys | HoSys</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <link href="{{asset('assets/vendors/base/vendors.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('assets/demo/default/base/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

<!-- Farsi Fonts -->
<link href="{{asset('css/saleh-farsi-font.css')}}" rel="stylesheet" type="text/css" />

<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
<link rel="shortcut icon" href="{{asset('favicon.png')}}" />

</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1"
            id="m_login" style="background-image: url(./assets/app/media/img//bg/bg-2.jpg);">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="#">
                            <img src="assets/app/media/img//logos/logo-1.png" class="">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h2 class="m-login__title m--font-bold ">ورود به سیستم</h2>
                        </div>
                        <form class="m-login__form m-form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group m-form__group">
                                <input class="form-control m-input text-center" type="email" value="{{ old('email') }}"
                                    required placeholder="یوزر یا ایمیل آدرس" name="email" autocomplete="off">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last text-center"
                                    type="password" placeholder="رمز عبور" required name="password">
                            </div>
                            @if($errors)
                            <div class="row m-login__form-sub">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                    @endforeach
                                </ul>
                                {{--<div class="col m--align-left m-login__form-left">--}}
                                {{----}}
                                {{--</div>--}}
                                {{-- </div>
                            @endif
                            <div class="m-login__form-action ">
                                <button id="m_login_signin_submit"
                                    class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary ">
                                    ورود
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!--begin::Base Scripts -->
    <script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
                                <script src="{{asset('assets/demo/default/base/scripts.bundle.js')}}"
                                    type="text/javascript"></script>
                                <!--end::Page Snippets -->

</body> --}}

<!-- end::Body -->

{{-- </html> --}}



<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>NF Info-Tech</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });

    </script>

    <!--end::Web font -->

    <link href="{{asset('assets/vendors/base/vendors.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/demo/default/base/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

    <!-- Farsi Fonts -->
    <link href="{{asset('css/saleh-farsi-font.css')}}" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
            id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper" style="padding-top:10%;">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="{{asset('img/isys-logo-o.png')}}" class="img-fluid">
                                </a>
                            </div>
                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">ورود به سیستم</h3>
                                </div>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form class="m-login__form m-form" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input text-center" type="email"
                                            value="{{ old('email') }}" required placeholder="یوزر یا ایمیل آدرس"
                                            name="email">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last text-center"
                                            type="password" placeholder="رمز عبور" required name="password">
                                    </div>
                                    @if($errors)
                                    <div class="row m-login__form-sub">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                            <li> {{ $error }} </li>
                                            @endforeach
                                        </ul>
                                        <div class="col m--align-left m-login__form-left">

                                        </div>
                                    </div>
                                    @endif
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit"
                                            class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ورود</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center"
                style="background-image: url(./img/login-background.png)">
                {{-- <div class="m-grid__item">
                    <h3 class="m-login__welcome">Join Our Community</h3>
                    <p class="m-login__msg">
                        Lorem ipsum dolor sit amet, coectetuer adipiscing
                        <br>elit sed diam nonummy et nibh euismod
                    </p>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>

    <!--end::Page Snippets -->
</body>

<!-- end::Body -->

</html>
