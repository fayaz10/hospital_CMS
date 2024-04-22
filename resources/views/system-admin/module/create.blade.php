@extends('layouts.app')

@section('csslibs')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
    @include('system-admin.partials.sidebar')
@endsection


@section('content')

  


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-university"></i> Create Module In Portal
                </div>
                <div class="card-block">

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-accent-info">
                                <form action="{{ url('/admin/module') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="card-header">
                                        <h3>Create Module</h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-from-label"> Module
                                                        Code
                                                    </label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="module_code" type="text"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-from-label"> Path
                                                    </label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="path" type="text"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-2 col-form-label">Name
                                                        (English)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" name="name_en" type="text"
                                                               id="example-text-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-search-input" class="col-2 col-form-label">Name
                                                        (دری)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" type="text"
                                                               name="name_dr" id="example-search-input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-search-input" class="col-2 col-form-label">Name
                                                        (پشتو)</label>
                                                    <div class="col-10">
                                                        <input class="form-control" type="text"
                                                               name="name_pa" id="example-search-input">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary"> &nbsp; &nbsp; <i
                                                            class="fa fa-folder"></i> Create Module &nbsp; &nbsp;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('plugins')
            <script src="{{ asset('js/libs/select2.min.js') }}"></script>
        @endsection
        @section('inline-script')
            <script type="text/javascript">
                $('#select2-department').select2();

                function syncModules(moduleId, userId) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'POST',
                        url: "{{ url('/admin/module/assign') }}",
                        data: {module: moduleId, user: userId},
                        success: function (result) {
//                            alert(result);
                        }
                    });

                }
            </script>
@endsection