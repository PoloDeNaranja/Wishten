@if ($message = Session::get('success'))

<div class="alert alert-info">
    {{ $message }}
</div>

@endif

@if ($message = Session::get('error'))

<div class="alert alert-danger">
    {{ $message }}
</div>

@endif
