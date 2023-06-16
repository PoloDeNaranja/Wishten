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


@isset($video)
    @if ($video->status != 'valid')
        <div class="alert error">
            Your video is {{ strtoupper($video->status) }}, which means it's not publicly accessible. Please contact the administrators.
        </div>
    @endif

@endisset
