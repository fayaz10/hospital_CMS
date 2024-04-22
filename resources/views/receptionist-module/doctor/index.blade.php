@extends('layouts.app')


@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('reception.rec_modul')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.frst_page')}}</span>
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
        @permission('rec_doc_show')
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
                        <a class="btn btn-secondary" href="{{ route('doctor.balance') }}">
                            <span> <i class="flaticon-graph"></i> <span>{{__('global.incomeBalance')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        @permission('rec_doc_create')
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('doctor.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        @endpermission
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('global.number')}}</th>
                        <th>{{__('admin.adm_name')}}</th>
                        <th>{{__('reception.docy_specialze')}}</th>
                        <th>{{__('reception.docy_fees')}}</th>
                        <th>{{__('reception.docy_email')}}</th>
                        <th>{{__('global.operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $key => $doctor)
                    <tr>
                        <td>{{ ($doctors->currentPage() == 0 ? 1 :$doctors->currentPage() - 1) * $doctors ->perPage() + $key + 1}}</td>
                        <td>{{ $doctor->first_name .' '. $doctor->last_name }}</td>
                        <td>{{ $doctor->specialist }}</td>
                        <td>{{ $doctor->visit_fee }} {{ $doctor->currency->label_dr }} </td>
                        <td>{{ $doctor->email }}</td>
                        <td>
                            <a href="{{ route('doctor.show', [$doctor->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            @permission('rec_doc_edit')
                            <a href="{{ route('doctor.edit', $doctor->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $doctors->links() }}
        </div>
        @endpermission
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '{{__("global.search")}}',
            dir: '{{ app()->isLocale("en") ? "ltr" : "rtl" }}',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('doctor.search') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name ,
                                fee: item.visit_fee,
                                specialist: item.specialist,
                                curency: item.curency,
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

        search.on("change", function (e) {
            var object = $(this).select2('data')[0];
            window.location.href = '{{ route("doctor.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><i class='la la-user'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'> <i class='flaticon-coins'> </i>" + repo.fee + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''><i class='la la-phone'></i> {{ __('reception.docy_specialze') }} : " + repo.specialist + "</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
@endsection
