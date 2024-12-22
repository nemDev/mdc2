<x-layout>
    <div class="d-flex justify-content-between">
        <h1 class="text-center d-inline">Upload Files</h1>
        <a href="{{route('users.index')}}" class="btn btn-primary" style="margin-bottom: 10px;">
            Back to users
        </a>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <form action="{{route('imports.upload')}}" method="POST" enctype='multipart/form-data'>
            @csrf
            <x-inputs.text
                id="username"
                name="username"
                label="Username"
                type="text"
                placeholder="Username"
            />

            <x-inputs.file
                id="files"
                name="files[]"
                label="DS Sheet"
            />

            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>
</x-layout>
