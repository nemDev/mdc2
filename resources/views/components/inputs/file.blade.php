@props([
    'id',
    'name',
    'label' => null,
    'value'=>'',
    'type' => 'file',
    'multiple' => true
])

<div class="form-group @error($name) has-error @enderror">
    @if($label)
        <label
            class="block text-gray-700"
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
        @if($multiple) multiple @endif
    />
    @error($name)
    <p class="help-block">
        {{$message}}
    </p>
    @enderror
</div>
