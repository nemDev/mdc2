@props([
    'options' => [],
    'name'    => '',
    'label'   => ''
])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <select
        {{ $attributes->merge(['class'=> 'form-control form-select']) }}
        id="{{$name}}"
        name="{{$name}}"
    >
        @foreach($options as $key => $option)
            <option value="{{$key}}">{{$option['label']}}</option>
        @endforeach
    </select>
</div>
