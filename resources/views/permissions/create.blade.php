<x-layout>
    <div class="d-flex justify-content-between">
        <h1 class="text-center d-inline">Create Permission</h1>
        <a href="{{route('permissions.index')}}" class="btn btn-primary" style="margin-bottom: 10px;">
            Back to permissions
        </a>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <form action="{{route('permissions.store')}}" method="POST">
            @csrf
            <x-inputs.text
                id="name"
                name="name"
                label="Name"
                type="text"
                placeholder="Permission name"
            />
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>
</x-layout>
