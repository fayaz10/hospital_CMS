@extends('layouts.app')


@section('sidebar')
    @include('system-admin.partials.sidebar')
@endsection


@section('content')

    <!-- @include('alerts.alert') -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-university"></i> {{ $module->name_en }}
                </div>
                <div class="card-block">

                    <div class="row">
                        <div class="col-12 mb-2">
                            <a href="{{ url('/admin/module/create') }}">
                                <button class="btn btn-success float-right ml-2">Create Module</button>
                            </a>
                            <a href="{{ url('/admin/module/' .$module->id.  '/edit') }}">
                                <button class="btn float-right ml-2"><i
                                            class="fa fa-edit"></i> Edit
                                </button>
                            </a>
                        </div>
                    </div>

                    <hr>


                    <div class="row">
                        <div class="col-9">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Module Code</label>
                                <div class="col-10">
                                    {{ $module->module_code }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Path</label>
                                <div class="col-10">
                                    {{ $module->path }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Name
                                    (English)</label>
                                <div class="col-10">
                                    {{ $module->name_en }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-search-input" class="col-2 col-form-label">Name
                                    (دری)</label>
                                <div class="col-10">
                                    {{ $module->name_dr }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Name
                                    (پشتو)</label>
                                <div class="col-10">
                                    {{ $module->name_pa }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
