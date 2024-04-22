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
                        <div class="col-md-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('experiment.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                            href="{{ route('experiment.create') }}">
                            <span> <i class="la la-plus"></i> <span>{{__('global.gol_create')}}</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            @include('errors.alert')
            <hr>

            <table class="table m-table m-table--head-separator-primary">
                <thead class="table-inverse">
                    <tr>
                        <th>{{__('global.number')}}</th>
                        <th>{{__('reception.pat_record')}}</th>
                        <th>{{__('reception.vis_patent')}}</th>
                        <th>{{__('reception.vis_doctors')}}</th>
                        <th>{{__('lab.lab_testNums')}}</th>
                        <th>{{__('pharmacist.pre_totalPayment')}}</th>
                        <th> {{__('admin.adm_state')}}</th>
                        <th>{{__('global.approval')}}</th>
                        <th>{{__('global.operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($experiments as $key => $experiment)
                    <tr>
                        <td>{{ ($experiments->currentPage() == 0 ? 1 :$experiments->currentPage() - 1) * $experiments ->perPage() + $key + 1}}
                        </td>
                        <td>{{ $experiment->record_no}}</td>
                        <td>{{ $experiment->patient->name }}
                            {{ __('lab.lab_(') . $experiment->patient->record_no . __('lab.lab_)') }}</td>
                        <td>{{ $experiment->doctor->name }}</td>
                        <td>{{ $experiment->tests_count }} {{-- $experiment->currency->label_dr --}} </td>
                        <td>
                            {{ $experiment->profit->totalAmount }}
                            {{ app()->getLocale() == 'en' ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                        </td>
                        <td>
                            @php
                                $status = optional($experiment->approve)->map(function ($item, $key) {
                                    if ($item->is_approved === 1)
                                        return '<span class="text-success la la-check"></span>';

                                    if ($item->is_approved === null)
                                        return '<span class="text-info la la-minus"></span>';

                                    if ($item->is_approved === 0)
                                        return '<span class="text-danger la la-close"></span>';
                                    
                                });
                                
                                echo implode(' ', optional($status)->toArray())
                            @endphp
                        </td>
                        <td><span
                                class="m-badge {{$experiment->is_approved ? 'm-badge--brand' : 'm-badge--danger' }} m-badge--wide">
                                {{ $experiment->is_approved ? __('global.received') : __('global.pending') }}
                            </span></td>
                        <td>
                            <a href="#" onclick="deleteData('{{  route('experiment.destroy', $experiment->id) }}', event)"> <i
                                    class="text-danger flaticon-delete-2"></i></a>
                            &nbsp;
                            <a href="{{ route('experiment.edit', $experiment->id) }}">
                                <i class="flaticon-edit"></i>
                            </a>
                            &nbsp;
                            <a href="{{ route('experiment.show', [$experiment->id]) }}">
                                <i class="flaticon-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $experiments->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">{{__('global.deletion')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('global.deletion_message')}}</p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" 
                    class="btn btn-danger" 
                    onclick="document.getElementById('form-delete').submit();">
                        {{__('global.yes')}}
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal">{{__('global.no')}}
                </button>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    function deleteData(route, e)
    {
        e.preventDefault();
        $('#form-delete').attr('action', route);
        $('#m_modal_1').modal('show');
    }

    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: 'Search by record number',
            dir: '{{ app()->isLocale("en") ? "ltr" : "rtl" }}',
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('experiment.search') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.record_no ,
                                name: item.patient.name,
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
            window.location.href = '{{ route("experiment.show", [null]) }}' + '/' + object.id;
        });
    });

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var markup = "<div class='select2-result-repository__statistics'>" +
                "<div class='float-left'><strong>" + repo.text + "</strong></div>" +
                "<div class='float-right'> </i>" + repo.name + "</div>" +
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
