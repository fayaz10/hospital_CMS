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
                        {{-- <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('patient.search') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a> --}}
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('patient.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('global.number')}}</th>
                        <th>{{__('reception.pat_name')}}</th>
                        <th>{{__('reception.sex')}}</th>
                        <th>{{__('reception.pat_record')}}</th>
                        <th>{{__('reception.pat_age')}}</th>
                        <th>{{__('reception.pat_phone')}}</th>
                        <th>{{__('global.gol_cret')}}</th>
                        <th>{{__('global.operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    if(app()->getLocale() == 'dr'){
                    setlocale(LC_TIME, 'fa_IR');
                    Carbon\Carbon::setLocale('fa');
                    }
                    @endphp
                    @foreach($patients as $key => $patient)
                    <tr>
                        <td>{{ ($patients->currentPage() == 0 ? 1 :$patients->currentPage() - 1) * $patients ->perPage() + $key + 1}}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ __("reception.{$patient->sex}") }}</td>
                        <td>{{ $patient->record_no }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->phone_no }}</td>
                        <td>{{ $patient->created_at ? $patient->created_at->diffForHumans() : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('patient.show', [$patient->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('patient.edit', $patient->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $patients->links() }}
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
                url: "{{ route('patient.search') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name + ' (' + item.record_no + ')',
                                record: item.record_no,
                                age: item.age,
                                phone: item.phone_no,
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
            window.location.href = '{{ route("patient.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><i class='la la-user'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'> {{ __('reception.pat_age') }} : " + repo.age + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''><i class='la la-phone'></i> <small>" + repo.phone + "</small></div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
@endsection
