@props([
    'name' => '',
    'label' => '',
    'checked' => false
])
<div class="form-group">
    <div class="checkbox">
        <label for="{{$name}}">
            <input type="checkbox" id="{{$name}}" name="{{$name}}" {{$attributes->merge(['class'=> ' '])}} checked="{{ old($name, $checked) }}"> {{$label}}
        </label>
    </div>
</div>
