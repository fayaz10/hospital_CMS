@extends('layouts.app')

@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{ __('reception.rec_modul') }}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('finance.sideDiverseIncome')}}</span>
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

            <div class="m-form m-form--label-align-right">
                <div class="row align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="col-md-8 col-lg-7">
                            <select name="search" id="quick-search" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('din.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                            <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air"
                                      href="{{ route('din.create') }}">
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
                        <th>{{__('pharmacist.med_number')}}</th>
                        <th> {{__('finance.incSection')}}</th>
                        <th> {{__('finance.dCategory')}}</th>
                        <th> {{__('finance.dSubject')}}</th>
                        <th> {{__('finance.dType')}}</th>
                        <th> {{__('reception.pay_tax')}}</th>
                        <th> {{__('reception.amountOfPayament')}}</th>
                        <th>{{__('reception.pay_discount')}}
                        <th> {{__('lab.lab_expCreatedAt')}}</th>
                        <th>{{__('pharmacist.med_operation')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $key => $income)
                    <tr>
                        <td>{{ ($incomes->currentPage() == 0 ? 1 :$incomes->currentPage() - 1) * $incomes ->perPage() + $key + 1}}</td>
                    <td>{{ __('finance.'.strtolower(basename($income->profit->profitable_type, '\\')))  }}</td>
                    <td>
                        {{ app()->getLocale() == 'en' ? $income->category->label_en : $income->category->label_dr }}
                    </td>
                    <td>{{ $income->subject }}</td>
                    <td>{{__("finance.{$income->type}")}}</td>
                    <td>
                        {{ $income->profit->taxes }}
                        {{ app()->getLocale() == 'en' ? $income->profit->currency->label_en : $income->profit->currency->label_dr }}
                    </td>
                    <td>
                        {{ $income->profit->totalAmount }}
                        {{ app()->getLocale() == 'en' ? $income->profit->currency->label_en : $income->profit->currency->label_dr }}
                    </td>
                    <td>{{ $income->discount ? $income->discount . '%' : '-' }}</td>
                    <td>{{ $income->created_at->format('Y-m-d g:i A') }}</td>

                    <td>
                        <a href="#" onclick="deleteData('{{  route('din.destroy', $income->id) }}', event)"> <i
                                    class="text-danger flaticon-delete-2"></i></a>
                            &nbsp;
                        <a href="{{ route('din.edit', [$income->id]) }}">
                            <i class="flaticon-edit"></i>
                        </a>
                        &nbsp;
                        <a href="{{ route('din.show', [$income->id]) }}">
                            <i class="flaticon-eye"></i>
                        </a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $incomes->links() }}
        </div>
    </div>
</div>
@endsection


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


@section('scripts')

<script src="{{asset('js/select2.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var search = $('#quick-search').select2({
            placeholder: '{{__("global.search")}}',
            dir: '{{ app()->isLocale("en") ? "ltr" : "rtl" }}',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('din.search') }}",
                dataType: 'json',
                type: "get",
                data: function(term) {
                    return term;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.subject,
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
            window.location.href = '{{ route("din.show", [null]) }}' + '/' + object.id;
        });
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository__statistics'>" +
            "<div class='float-left'><strong>" + repo.text + "</strong></div>" +
            // "<div class='float-right'>  <i class='flaticon-coins'> </i>" + repo.price + "</div>" +
            "<div class='clear-both'></div><br>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }

    function deleteData(route, e)
    {
        e.preventDefault();
        $('#form-delete').attr('action', route);
        $('#m_modal_1').modal('show');
    }
    
</script>
@endsection