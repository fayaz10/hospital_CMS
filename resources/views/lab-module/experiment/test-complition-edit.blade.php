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
                    <a href="{{route('visit.index')}}" class="m-nav__link">
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
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-progress">

                <!-- here can place a progress bar-->
            </div>
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="la la-user"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('lab.lab_expEdit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ route('experiment.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>{{__('global.gol_back')}}</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" id="save-button" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{__('global.gol_save')}}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- <form class="m-form m-form--label-align-left m-form--state col-12" > -->
            <form action="{{ route('test-completion.update', [$test_completion->id]) }}" onsubmit="var desc = $('#description'); desc.val('\'\n' +desc.val())" id="save-form" class="m-form m-form--label-align-left m-form--state col-12" method="post">
                {{ csrf_field() }}
                @method('put')
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="form-group m-form__group-sub">
                                <label for="experimentor" class="form-control-label">{{__('lab.lab_test')}}</label>
                                <strong><p>{{ optional($test_completion->test)->name }}</p></strong>
                            </div>
                            <div class="form-group m-form__group-sub">
                                <label for="experimentor" class="form-control-label">{{__('lab.lab_expExperimentor')}}</label>
                                <input type="text" required value="{{ $test_completion->experimentor ?? auth()->user()->name }}" class="form-control" name="experimentor" id="experimentor">
                            </div>
        
                            <div class="form-group m-form__group row">
                                <div class="col-md-12 m-form__group-sub">
                                    <label for="results" class="form-control-label">{{__('pharmacist.r_range')}}</label>
                                    {{-- <textarea required class="form-control lined-textarea" style="overflow: hidden" name="results" rows="25" id="results">{{ $test_completion->results }}</textarea> --}}
                                    <textarea required class="form-control summernote" name="results" rows="25" id="results"></textarea>
                                    {{-- <div class="summernote" id="m_summernote_1"></div> --}}
                                </div>
                                
                                {{-- <div class="col-md-6 m-form__group-sub">
                                    <label for="description" class="form-control-label">{{__('pharmacist.p_value')}}</label>
                                    <textarea required class="form-control lined-textarea" name="description" rows="25" id="description">{{ substr($test_completion->description, 1) }}</textarea>
                                </div> --}}
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/messages_' . app()->getLocale() . '.js') }}"></script>

<script type="text/javascript">
    $('#save-button').click(function() {
        var form = $('#save-form');
        form.validate();
        if (form.valid())
            form.submit();
    });

    $(document).ready(function () {
        
        var markupStr = `
                @if ($test_completion->results)
                    {!! $test_completion->results !!}
                @else
                    @forelse (optional($test_completion->test)->subTests as $key => $subTest)
                        <strong>{{ ++$key }}. {{ $subTest->name }}</strong><br>
                        {!! nl2br($subTest->range) !!}
                    @empty
                        --
                    @endforelse
                @endif
        `;
        $(".summernote").summernote({
            height:400,
            toolbar: [
                ['style', ['bold']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ],
            'code': markupStr
        })
        $(".summernote").summernote("code", markupStr)
    });

</script>
@endsection