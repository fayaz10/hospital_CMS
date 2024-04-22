@extends('layouts.app')

@section('csslibs')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
    @include('system-admin.partials.sidebar')
@endsection


@section('content')

    <!-- @include('alerts.alert') -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-block">

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-accent-info">
                                <div class="card-header">
                                    <h3>Module Information</h3>
                                </div>
                                <div class="card-block">
                                    <form action="{{ url('admin/module/'.$module->id) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {{ method_field('put') }}
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">Module
                                                        Code
                                                    </label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="module_code" type="text"
                                                               value="{{ $module->module_code }}"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">
                                                        Path
                                                    </label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="path" type="text"
                                                               value="{{ $module->path }}"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">Name
                                                        (English)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="name_en" type="text"
                                                               value="{{ $module->name_en }}"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">Name
                                                        (دری)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="name_dr" type="text"
                                                               value="{{ $module->name_dr }}"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">Name
                                                        (پشتو)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="name_pa" type="text"
                                                               value="{{ $module->name_pa }}"
                                                               id="example-text-input">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr>


                </div>
            </div>
        </div>

        @endsection

        @section('plugins')
            <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endsection
