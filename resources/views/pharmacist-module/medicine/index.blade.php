@extends('layouts.app')


@section('sidebar')
@include('pharmacist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('pharmacist.med_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text"> {{__('global.gol_fpage')}}</span>
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
                        <select name="search" id="quick-search" class="form-control">
                        </select>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('medicine.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="btn-group">
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('medicine.create') }}">
                                <span> <i class="la la-plus"></i> <span>{{ __('global.create') }}</span>
                                </span>
                            </a>
                            <button type="button" class="btn  btn-focus m-btn--air dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">
                                    {{ __('global.gol_more_options') }}
                                </span>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(80px, 40px, 0px);">
                                <a class="dropdown-item" href="{{ route('medicine.create') .'?multiple' }}">
                                    {{ __('global.gol_create_multiple') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('medicine.edit-multipe') }}">
                                    {{ __('global.edit_multiple') }}
                                </a>
                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <hr>
            @include('errors.alert')
            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('pharmacist.med_number')}}</th>
                        <th> {{__('pharmacist.med_name')}}</th>
                        <th>{{__('pharmacist.med_milligram')}} </th>
                        <th> {{__('pharmacist.med_type')}}</th>
                        <th> {{__('pharmacist.med_company')}}</th>
                        <th> {{__('pharmacist.med_excist')}}</th>
                        <th> {{__('pharmacist.med_price')}}</th>
                        <th> {{__('pharmacist.med_expire_date')}}</th>
                        <th>{{__('pharmacist.med_operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicines as $key => $medicine)
                    <tr class="{{ optional($medicine->expire_date)->lte(now()->addMonths(3)) ? 'm-table__row--warning' : null }}">
                        <td>{{ ($medicines->currentPage() == 0 ? 1 :$medicines->currentPage() - 1) * $medicines ->perPage() + $key + 1}}</td>
                        <td>{{ $medicine->name  }}</td>
                        <td>{{ $medicine->milligram }}</td>
                        <td>{{ app()->getLocale() == 'en' ? $medicine->type->label_en : $medicine->type->label_dr }}</td>
                        <td>{{ $medicine->company }}</td>
                        <td>
                            @if ($medicine->store)
                            {{ $medicine->store->quantity }}
                            @else
                            0
                            @endif
                            {{ app()->getLocale() == 'en' ? $medicine->unit->label_en : $medicine->unit->label_dr }}
                        </td>
                        <td>
                            @if ($medicine->store)
                            {{ $medicine->store->unit_price }} {{ app()->getLocale() == 'en' ? $medicine->store->currency->label_en : $medicine->store->currency->label_dr }}
                            @else
                            Undefined
                            @endif
                        </td>
                        <td>{{ optional($medicine->expire_date)->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('medicine.show', [$medicine->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('medicine.edit', $medicine->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $medicines->links() }}
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
                url: "{{ route('medicine.search') }}",
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
                                mg: item.milligram + ' mg',
                                company: item.company,
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
            window.location.href = '{{ route("medicine.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'></i> <strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'>" + repo.mg + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class=''>" + repo.company + "</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
@endsection
