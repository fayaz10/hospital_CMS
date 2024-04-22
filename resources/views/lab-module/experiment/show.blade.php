@extends('layouts.app')

@section('sidebar')
@include('lab-module.partials.sidebar')
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
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-2 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-10 order-1 order-xl-2 m--align-right">
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('experiment.refund', [$experiment->id]) }}" class="btn btn-warning"
                            onclick="return confirm('{{ __('global.sure2refund') }}') ? confirm('{{ __('global.irreversable') }}')  : false;">
                            <span> <i class="la la-refresh"></i> <span>{{__('global.refundAll')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <div class="btn-group">

                            <a href="{{ route('experiment.print', [$experiment->id]) }}" class="btn btn-secondary">
                                <span> <i class="la la-print"></i> <span>{{__('global.print')}}</span> </span> </a>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">
                                    {{ __('global.gol_more_options') }}
                                </span>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(80px, 40px, 0px);">
                                <a class="dropdown-item" href="{{ route('experiment.print', [$experiment->id]) }}">
                                    {{ __('global.print') }} {{ __('lab.lab_expBill') }}
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('experiment.print', [$experiment->id]) .'?result' }}">
                                    {{ __('global.print') }} {{ __('lab.lab_expResults') }}
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('experiment.form', [$experiment->id]) }}">
                                    {{ __('global.resultForm') }}
                                </a>
                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#m_modal_attachment">
                            <span> <i class="la la-files-o"></i> <span>{{__('global.new_file')}}</span> </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('experiment.filter') }}" class="btn btn-secondary">
                            <span> <i class="la la-filter"></i> <span>{{__('global.filter')}}</span> </span> </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                        <a href="{{ route('experiment.edit', [$experiment->id]) }}" class="btn btn-secondary">
                            <span> <i class="la la-pencil"></i> <span>{{__('global.gol_edit')}}</span> </span> </a>
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
            @include('errors.validation-errors')
            <hr>
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">

                        <!--Student Information -->
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading ">
                                <h3 class="m-form__heading-title">{{__('lab.lab_expInf')}}</h3>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('reception.vis_record')}}</label>
                                    <p><strong>{{ $experiment->record_no }}</strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label">{{__('reception.vis_patent')}}</label>
                                    <p><strong>{{ $experiment->patient->name }}
                                            {{ __('lab.lab_(') . $experiment->patient->record_no . __('lab.lab_)') }}</strong>
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('reception.vis_doctors')}}</label>
                                    <p><strong>{{ $experiment->doctor->name }}
                                            ({{ $experiment->doctor->specialist }})</strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('lab.lab_expCreatedAt')}} </label>
                                    <p><strong>{{ $experiment->created_at->format('Y-m-d') }}</strong></p>
                                </div>
                            </div>

                            <div class="row form-group m-form__group ">
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_netIncome')}}</label>
                                    <p><strong>
                                            {{ $experiment->profit->amount }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_taxes')}}</label>
                                    <p><strong>
                                            {{ $experiment->profit->taxes }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.pre_totalPayment')}}</label>
                                    <p><strong>
                                            {{ $experiment->profit->totalAmount }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </strong></p>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label"> {{__('pharmacist.med_register')}}</label>
                                    <p><strong>
                                            {{ app()->isLocale('en') ? $experiment->profit->registrar->name : $experiment->profit->registrar->name_dr }}
                                        </strong></p>
                                </div>
                            </div>

                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading ">
                                    <h3 class="m-form__heading-title"> {{__('lab.lab_expTestsDone')}}</h3>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead class="thead-inverse">
                                    <tr class="h5">
                                        <th> {{__('pharmacist.med_number')}}</th>
                                        <th> {{__('lab.lab_expDescription')}}</th>
                                        {{-- <th> {{__('pharmacist.r_range')}}</th> --}}
                                        <th> {{__('global.sub_test_name')}}</th>
                                        {{-- <th> {{__('pharmacist.p_value')}}</th> --}}
                                        <th> {{__('pharmacist.med_totalPrice')}}</th>
                                        <th>
                                            <!-- <button class="btn btn-outline-primary btn-sm" onclick="addNew(event)"
                                                data-toggle="modal" data-target="#m_modal_3">
                                                <i class="flaticon-plus"></i>
                                            </button> -->
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($experiment->tests as $key => $test)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $test->name  }}</td>
                                        {{-- <td><pre>{!! $test->pivot->description !!}</pre></td> --}}
                                        <td>
                                            @if ($test->pivot->results)
                                                {!! $test->pivot->results !!}
                                            @else
                                                @forelse ($test->subTests as $key => $subTest)
                                                    <strong>{{ ++$key }}. {{ $subTest->name }}</strong><br>
                                                    <span ><pre class="ml-5">{!! $subTest->range !!}</pre></span>
                                                @empty
                                                    --
                                                @endforelse
                                            @endif
                                        </td>
                                        {{-- <td><pre>{!! substr($test->pivot->description, 1) !!}</pre></td> --}}
                                        <td>
                                            {{ $test->pivot->price }}
                                            {{ app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm" href="{{ route('test-completion.edit', $test->pivot->id) }}">
                                                <i class="flaticon-edit-1"></i>
                                            </a>
                                            <!-- <button class="btn btn-sm"
                                                onclick="event.preventDefault();editTestCompletion('{{$test->pivot->id}}')">
                                                <i class="flaticon-edit-1"></i>
                                            </button> -->
                                            <!-- &nbsp;
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="event.preventDefault();deleteTestCompletion('{{$test->pivot->id}}')">
                                                <i class="flaticon-delete-1"></i>
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet m-portlet--full-height ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ __('global.attachments') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="m-portlet__body">

            <!--begin::m-widget4-->
            <div class="m-widget4">

                @forelse($experiment->attachments as $attachment)
                <div class="m-widget4__item">
                    <div class="m-widget4__img m-widget4__img--icon">
                        <img src="{{ file_exists('assets/app/media/img/files/' . $attachment->mime_type . '.svg') ? asset('assets/app/media/img/files/' . $attachment->mime_type . '.svg') : asset('assets/app/media/img/files/unkown.svg') }}"
                            alt="">
                    </div>
                    <div class="m-widget4__info">
                        <span class="m-widget4__text">
                            {{ $attachment->label }}
                        </span>
                    </div>
                    <div class="m-widget4__ext">
                        <a href="{{ route('attachment.download', ['Experiment', $attachment->id]) }}"
                            class="btn btn-secondary btn-icon btn-lg">
                            <i class="la la-download text-primary"></i>
                        </a>
                    </div>
                    <div class="m-widget4__ext">
                        <!-- <a class="btn btn-clean btn-icon btn-lg"
                            data-href="{{ route('attachment.delete', ['Experiment', $attachment->id ]) }}"
                            onclick="confirmDelete(event)" data-toggle="modal" data-target="#confirmationModal"> -->
                            <button class="btn btn-secondary btn-icon btn-lg" 
                                onclick="deleteData('{{ route('attachment.delete', ['Experiment', $attachment->id ]) }}', event)">
                                <i class="la la-remove text-danger"></i>
                            </button>
                        <!-- </a> -->
                    </div>
                </div>
                @empty
                {{__('global.no_attachments')}}
                @endforelse

            </div>

            <!--end::Widget 9-->
        </div>
    </div>
</div>


<!-- Modals -->
<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('lab.lab_expEditTestedExp')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('test-completion.update', [null]) }}" onsubmit="var desc = $('#description'); desc.val('\'\n' +desc.val())" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    @method('put')
                    <div class="form-group">
                        <label for="experimentor" class="form-control-label">{{__('lab.lab_expExperimentor')}}</label>
                        <input type="text" class="form-control" name="experimentor" id="experimentor">
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6">
                            <label for="results" class="form-control-label">{{__('pharmacist.r_range')}}</label>
                            <textarea class="form-control lined-textarea" style="overflow: hidden" name="results" rows="15" id="results"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="description" class="form-control-label">{{__('pharmacist.p_value')}}</label>
                            <textarea class="form-control lined-textarea" name="description" rows="15" id="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('global.gol_save2')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_modal_3" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('lab.lab_expAddTestToExp')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('test-completion.store') }}" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="experiment_id" value="{{ $experiment->id }}">
                    <div class="form-group m-form__group">
                        <label for="experimentor" class="form-control-label">{{__('lab.lab_testName')}}</label>
                        <select class="form-control m-input" style="width: 100%" id="newTestAdd"
                            name="test_id"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('global.gol_save2')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_modal_2" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('lab.lab_expDeleteTest')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('test-completion.destroy', [null]) }}" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    @method('delete')
                    <input type="hidden" name="experiment_id" value="{{ $experiment->id }}">
                    <p>
                        {{__('lab.lab_expDeleteMessage')}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('global.delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="m_modal_attachment" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('global.add_attachment')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('attachment.upload',['Experiment',$experiment->id]) }}" enctype="multipart/form-data" id="save-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group m-form__group">
                        <label for="experimentor" class="form-control-label">{{__('global.select_file')}}</label>
                        <div class="custom-file">
                            <input type="file"  name="attachments[]" multiple class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">{{__('global.choose_file')}}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('global.upload')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="m_modal_delete" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('global.deletion')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" id="delete-form" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{method_field('delete')}}
                    <p>{{__('global.deletion_message')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('global.no')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('global.yes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
@endsection

@section('scripts')

<script type="text/javascript">
    $('#newTestAdd').select2({
        // theme: "bootstrap",
        placeholder: "Required",
        minimumInputLength: 2,
        ajax: {
            url: "{{ route('experiment.filter.ajax') }}",
            dataType: 'json',
            type: "get",
            data: function (term) {
                return {
                    name: term.term
                };
            },
            processResults: function (data) {
                return {
                    // results: data
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
        }
    });

    function editTestCompletion(id) {

        $('#m_modal_4').modal('toggle');
        $('#m_modal_4 #description').val('');
        form.attr('action', null);

        mApp.block("#m_modal_4 .modal-body", {
            overlayColor: "#000000",
            type: "loader",
            message: "Loading ..."
        });

        $.ajax({
            type: 'GET',
            url: '{{ route("test-completion.show", [null]) }}' + '/' + id,
            dataType: 'json',
            success: function (data) {
                mApp.unblock('.modal-body');
                $('#m_modal_4 #experimentor').val(data.experimentor);
                $('#m_modal_4 #results').val(data.results);

                var form = $('#m_modal_4 #save-form');
                form.attr('action', form.attr('action') + '/' + id);

                $('#m_modal_4 #description').val(data.description.substring(data.description.indexOf("\n") + 1));

            },
            error: function (jqXHR, exception) {
                mApp.block("#m_modal_4 .modal-body", {
                    overlayColor: "#000000",
                    type: "loader",
                    message: "Something bad happened to server couldn't load data ..."
                });
            }
        });
    }

    function deleteTestCompletion(id) {
        $('#m_modal_2').modal('toggle');
        var form = $('#m_modal_2 #save-form');
        form.attr('action', form.attr('action') + '/' + id);
    }

    function deleteData(route, e)
    {
        e.preventDefault();
        $('#delete-form').attr('action', route);
        $('#m_modal_delete').modal('show');
    }

</script>

@endsection
