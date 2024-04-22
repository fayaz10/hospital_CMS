@extends('layouts.master')

@section('csslibs')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/jquery-confirm.min.css') }}">
@endsection


@section('sidebar')
    @include('systemadmin.partials.sidebar')
@endsection


@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-check-square"></i> Role <strong> {{ $role->name }}</strong> belong's to
                    <storng><span class="bg-primary text-white"> &ensp;{{ $role->module->name_en }}&ensp; </span></storng>
                </div>
                <div class="card-block">
                    {{-- Option button--}}
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <a href="{{ url('/admin/role/create') }}">
                                <button class="btn btn-success float-right ml-2">Create New</button>
                            </a>
                            <button onclick="removePerms()"
                                    class="btn btn-danger float-right"><i class="fa fa-trash"></i> Manage Perms</button>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Unique name</label>
                        <div class="col-10">
                            {{--<input class="form-control" type="text" name="name">--}}
                            {{ $role->name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input"
                               class="col-2 col-form-label">Labels(English,Dari,Pashto)</label>
                        <div class="col-3">
                            {{--<input class="form-control" type="text" name="label_en" placeholder="English">--}}
                            {{ $role->label_en }}
                        </div>
                        <div class="col-3">
                            {{--<input class="form-control" type="text" name="label_dr" placeholder="دری">--}}
                            {{ $role->label_dr }}
                        </div>
                        <div class="col-4">
                            {{--<input class="form-control" type="text" name="label_pa" placeholder="پشتو">--}}
                            {{ $role->label_pa }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Related Module</label>
                        <div class="col-10">
                            {{ $role->module->name_en }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Descriptions</label>
                        <div class="col-3">
                            {{--<textarea name="desc_en" class="form-control" rows="5" placeholder="English"></textarea>--}}
                            {{ $role->desc_en }}
                        </div>
                        <div class="col-3">
                            {{--<textarea name="desc_dr" class="form-control" rows="5" placeholder="دری"></textarea>--}}
                            {{ $role->desc_dr }}
                        </div>
                        <div class="col-4">
                            {{ $role->desc_pa }}
                            {{--<textarea name="desc_pa" class="form-control" rows="5" placeholder="پشتو"></textarea>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-check-square-o"></i> Permission for <strong>{{ $role->name }}</strong>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-12">
                            <ol id="perms-list">
                                @foreach($role->permissions as $key => $permission)
                                    <li>
                                        {{ $permission->label_en }} | {{ $permission->name }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-check-square-o"></i> Add new permission <strong>{{ $role->name }}</strong>
                </div>
                <div class="card-block">
                    <form id="addPerms">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $role->id }}" name="role_id">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Unique name</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-2 col-form-label">Labels(English,Dari,Pashto)</label>
                            <div class="col-3">
                                <input class="form-control" type="text" name="label_en" placeholder="English">
                            </div>
                            <div class="col-3">
                                <input class="form-control" type="text" name="label_dr" placeholder="دری">
                            </div>
                            <div class="col-4">
                                <input class="form-control" type="text" name="label_pa" placeholder="پشتو">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Related Module</label>
                            <div class="col-10">
                                <select name="module_id" id="select2-department"
                                        class="js-example-basic-single form-control">
                                    @foreach(\App\Models\SysAdmin\Module::all() as $module)
                                        <option value="{{ $module->id }}">{{ $module->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Descriptions</label>
                            <div class="col-10">
                                <textarea name="description" class="form-control" rows="5"
                                          placeholder="English"></textarea>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-2 offset-10">
                                <button class="btn bg-primary form-control float-right" onclick="createPerm()">Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('plugins')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/jquery-confirm.min.js') }}"></script>
@endsection

@section('inline-script')
    <script type="application/javascript">
        $('#select2-department').select2();

        function createPerm() {
            $('#addPerms').submit(function (e) {

                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/role/perm/create') }}",
                    data: $("#addPerms").serialize(), // serializes the form's elements.
                    success: function (data) {
                        if (data == 1) {
                            $.confirm({
                                title: 'Encountered an error!',
                                content: 'Sorry!, we are not able to create permission right now.',
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    close: function () {
                                    }
                                }
                            });
                        } else {
                            $.confirm({
                                title: 'Successful Alert!',
                                content: 'You have successfully added new permission.',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    close: function () {
                                    }
                                }
                            });
                            $('#addPerms')[0].reset();
                            $('#perms-list').append('<li>' + data.label_en + '</li>');
                        }
                    }
                });
                e.preventDefault(); // avoid to execute the actual submit of the form.
            });
        }

        function removePerms() {
            $.confirm({
                title: 'Manage Permissions!',
                {{--content: '<table class="table" id="perms-list"> @foreach($role->permissions as $key=> $permission)<tr><td> <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0"> <input type="checkbox" name="{{ $permission->id }}"  checked class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"> </span> </label></td><td>{{$permission->label_en}}</td><td>{{ $permission->name }}</td><td> {{ $permission->description }}</td></tr> @endforeach</table>',--}}
                content: '<table class="table" id="perms-list"> @foreach($role->permissions as $key=> $permission)<tr> <td>&nbsp;</td><td> <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0"> <input type="checkbox" name="{{ $permission->id }}" checked class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"> </span> </label></td><td>{{$permission->label_en}}</td><td>{{ $permission->name }}</td><td> {{ $permission->description }}</td></tr>@endforeach @foreach(\App\Models\SysAdmin\Permission::where("module_id",$role->module->id)->whereNotIn("id",$role->permissions()->pluck("id"))->get() as $key=> $permission)<tr><td>&nbsp;</td><td> <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0"> <input type="checkbox" name="{{ $permission->id }}" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"> </span> </label></td><td>{{$permission->label_en}}</td><td>{{ $permission->name }}</td><td> {{ $permission->description }}</td></tr> @endforeach</table>',
                columnClass: 'col-10',
                buttons: {
                    formSubmit: {
                        text: 'Sync',
                        btnClass: 'btn-blue',
                        action: function () {
                            var selected = [];
                            $('#perms-list input:checked').each(function() {
                                selected.push($(this).attr('name'));
                            });
                            var self = this;
                            return $.ajax({
                                url: '{{ url('/admin/role/perm/assign') }}',
                                method: 'post',
                                data: {selected:selected,"_token": "{{ csrf_token() }}",role_id:"{{ $role->id }}"}
                            }).done(function (response) {
                                location.reload();
                            }).fail(function(){
                                self.setContent('Something went wrong.');
                            });
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
            });
        }
    </script>
@endsection
