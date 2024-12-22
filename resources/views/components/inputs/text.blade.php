@props([
    'id',
    'name',
    'label' => null,
    'type'=>'text',
    'value'=>'',
    'placeholder' => '',
    'description' => ''
    ])
<div class="mb-4 form-group @error($name) has-error @enderror">
    @if($label)
        <label
            class=""
            for="{{$id}}"
        >
            {{$label}}
        </label>
    @endif

    <input
        id="{{$id}}"
        type="{{$type}}"
        name="{{$name}}"
        class="form-control"
        placeholder="{{$placeholder}}"
        value="{{ old($name, $value) }}"
    />
    @if($description)
        <span>{{$description}}</span>
    @endif
    @error($name)
        <span class="help-block">{{$message}}</span>
    @enderror
</div>

