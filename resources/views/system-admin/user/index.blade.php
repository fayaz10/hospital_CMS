@extends('layouts.app')


@section('sidebar')
@include('system-admin.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('global.adm_users_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('global.gol_fpage')}}</span>
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
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
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
                        <div class="col-md-8 col-lg-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ url('/admin/user/create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            @include('errors.alert')

            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('global.number')}}</th>
                        <th>{{__('reception.docy_email')}}</th>
                        <th>{{__('admin.adm_EnName')}}</th>
                        <th>{{__('admin.adm_FrName')}}</th>
                        <th>{{__('admin.adm_state')}}</th>
                        <th>{{__('global.operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user )
                    <tr class="{{ !$user->blocked_at ? : 'bg-dark text-white' }}">
                        <td>{{ ($users->currentPage() == 0 ? 1 :$users->currentPage() - 1) * $users ->perPage() + $key + 1}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->name_dr }}</td>
                        <td>{{ !$user->blocked_at ? __('admin.adm_active') : __('admin.adm_deActive') }}</td>
                        <td>
                            <!-- <a href="#" onclick="deleteData('{{ $user->id }}', event)"> <i class="text-danger flaticon-delete-2"></i></a></a>
                            &nbsp; -->
                            <a href="{{ url('/admin/user/' . $user->id .'/edit') }}"><i class="flaticon-edit"></i></a>
                            &nbsp;
                            <a href="{{ url('/admin/user/' . $user->id) }}"><i class="flaticon-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
</div>

<form method="post" style="display:none" action="" id="form-delete">
    {{csrf_field()}}
    {{method_field('delete')}}
</form>

<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
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
                <button type="button" 
                    class="btn btn-danger" 
                    onclick="document.getElementById('form-delete').submit();">
                         بلی
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal">نخیر
                </button>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script src="{{asset('js/select2.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '{{__("global.search")}}',
            dir: '{{ app()->isLocale("en") ? "ltr" : "rtl" }}',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('user.search') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                name: item.name,
                                name_dr: item.name_dr,
                                email: item.email,
                                id: item.id
                            }
                        })
                    };
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        search.on("change", function(e) {
            var object = $(this).select2('data')[0];
            window.location.href = '{{ route("user.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><strong>" + repo.name + "</strong></div>" +
            "<div class='float-right'><strong>" + repo.name_dr + "</strong></div>" +
            "<div class='clear-both'></div><br>" +
            "<div >" + repo.email + "</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }

    function deleteData(id, e)
    {
        e.preventDefault();
        $('#form-delete').attr('action','{{url("/admin/user/")}}' + '/' + id);
        $('#m_modal_1').modal('show');
    }
</script>
@endsection