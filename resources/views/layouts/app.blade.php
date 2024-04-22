<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    @include('layouts.includes.head')
    @section('styles')
    @show
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- BEGIN: Header -->
@include('layouts.includes.navbar')
<!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
    @include('layouts.includes.sidebar')
    <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            @section('content')
            @show
        </div>
    </div>

    <!-- end:: Body -->

    <!-- start:: Footer -->
    @include('layouts.includes.footer')
    <!-- end:: Footer -->
    
</div>

<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<!-- begin::scripts -->
<!-- @include('layouts.includes.footer') -->
@include('layouts.includes.scripts')

@section('plugins')
@show

@section('scripts')
@show

<!-- end:: scripts -->

</body>

<!-- end::Body -->
</html>