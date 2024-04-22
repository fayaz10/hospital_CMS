@if (session()->has('alert'))
<div class="alert {{ session()->has('class') ? session()->get('class') : 'alert-info' }} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h3>
        {{ __('global.' . session()->get('alert')) }}
    </h3>
    @if (session()->has('message'))
    <p>
        {{ session()->get('message') }}
    </p>
    @endif
</div>
@endif