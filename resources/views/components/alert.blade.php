@props([
    'type',
    'message',
    'timeout'
])

@if(session()->has($type))
    <div class="callout {{$type == 'success' ? 'callout-success' : 'callout-danger'}} alert">
        <h4>{{ $message }}</h4>
    </div>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function (){
        const alert = document.querySelector('.alert');
        setTimeout(function () {
            alert.style.display = 'none';
        }, 2500)
    } )
</script>

