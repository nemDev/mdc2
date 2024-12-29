@props([
    'type' => '',
    'file' => ''
])
<div class="row">
    <div class="col-sm-6" style="display: flex; gap: 5px">
            <form style="display: flex; gap: 5px">
                <x-inputs.text
                    id="search"
                    name="search"
                    placeholder="search"
                    :value="request()->get('search')"
                />
                <div>
                    <button class="btn btn-primary mb-4" type="submit">Filter</button>
                </div>
            </form>
            <form action="{{route('imports.export', [$type, $file])}}" method="POST" class="filterFrom" >
                @csrf
                <input type="hidden" name="search" value="{{request()->get('search')}}">
                <button class="btn btn-primary" type="submit">Export</button>
            </form>
    </div>
</div>
