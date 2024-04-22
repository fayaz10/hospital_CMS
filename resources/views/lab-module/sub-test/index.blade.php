@extends('layouts.app')


@section('sidebar')
    @include('lab-module.partials.sidebar')
@endsection

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{__('lab.lab_mod')}}</h3>
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
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
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
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="{{ route('sub-test.create') }}">
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
                        <th>{{__('global.sub_test_name')}}</th>
                        <th>{{__('global.original_test_name')}}</th>
                        <th>{{__('pharmacist.r_range')}}</th>
                        <th>{{__('global.operation')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tests as $key => $test)
                         <tr>
                            <td>{{ ($tests->currentPage() == 0 ? 1 :$tests->currentPage() - 1) * $tests->perPage() + $key + 1}}</td>
                            <td>{{ $test->name }}</td>
                            <td>{!! implode(' <span class="text-info la la-minus"></span> ', optional($test->tests)->pluck('name', 'id')->toArray()) !!}</td>
                            <td>
                                <pre>{!! $test->range !!}</pre>
                            </td>
                            <td>
                                <a href="{{ route('sub-test.edit', $test->id) }}">
                                    <i class="flaticon-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{$tests->links() }}
            </div>
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
                url: "{{ route('test.search') }}",
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
                                price: item.price,
                                label_en: item.label_en,
                                label_dr: item.label_dr,
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
            window.location.href = '{{ route("test.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><strong>" + repo.text + "</strong></div>" +
            "<div class='float-right'>  <i class='flaticon-coins'> </i>" + repo.price + "</div>" +
            "<div class='clear-both'></div><br>" +
            "<div class='float-left'>" + repo.label_dr + "</div>" +
            "<div class='float-right'>" + repo.label_en + "</div>" +
            "<div class='clear-both'></div><br>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
</script>
@endsection

