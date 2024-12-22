@props([
    'type',
    'message',
    'timeout'
])

@if(session()->has($type))
    <div class="callout {{$type == 'success' ? 'callout-success' : 'callout-danger'}}">
        <h4>{{ $message }}</h4>
    </div>
@endif

