@if ($message = Session::get('success'))

<div class="alert success">
    {{ $message }}
</div>

@endif

@if ($message = Session::get('error'))

<div class="alert error">
    {{ $message }}
</div>

@endif
