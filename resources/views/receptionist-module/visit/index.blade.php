@extends('layouts.app')


@section('sidebar')
@include('receptionist-module.partials.sidebar')
@endsection

@section('content')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{__('reception.vis_module')}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">{{__('reception.vis_pat_visit')}}</span>
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
                        <div class="col-md-6">
                            {{-- <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--air" placeholder="{{__('global.search')}}">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span><i class="la la-search"></i></span> </span>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                    <a href="{{ route('visit.search') }}" class="btn btn-secondary">
                        <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                    <a class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air" href="{{ route('visit.create') }}">
                        <span> <i class="la la-plus"></i> <span>{{__('global.create')}}</span>
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
                    <th>{{__('reception.pat_name')}}</th>
                    <th>{{__('reception.docy_name')}}</th>
                    <th>{{__('reception.vis_section')}}</th>
                    <th>{{__('reception.vis_cashier')}}</th>
                    <th>{{__('reception.vis_discount')}}</th>
                    <th>{{__('global.operation')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visits as $key => $visit)
                <tr>
                    <td>{{ ($visits->currentPage() == 0 ? 1 :$visits->currentPage() - 1) * $visits ->perPage() + $key + 1}}</td>
                    <td>{{ $visit->patient->record_no }}</td>
                    <td>{{ $visit->patient->name }}</td>
                    <td>{{ $visit->doctor->name }}</td>
                    <td>{{ $visit->doctor->specialist }}</td>
                    <td>{{ app()->getLocale() == 'en' ? $visit->cashier->name : $visit->cashier->name_dr }}</td>
                    <td>{{ $visit->discount ? $visit->discount . '%' : __('reception.doesntHas')}} </td>
                    <td>
                        <a href="#" onclick="deleteData('{{  route('visit.destroy', $visit->id) }}', event)"> <i class="text-danger flaticon-delete-2"></i></a>

                        &nbsp;
                        <a href="{{ route('visit.edit', $visit->id) }}">
                            <i class="flaticon-edit"></i>
                        </a>
                        &nbsp;
                        <a href="{{ route('visit.show', [$visit->id]) }}">
                            <i class="flaticon-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $visits->links() }}
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
</script>

@endsection