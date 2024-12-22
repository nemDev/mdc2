<x-layout>
    <div class="d-flex justify-content-between">
        <h1 class="text-center d-inline">Create User</h1>
        <a href="{{route('users.index')}}" class="btn btn-primary" style="margin-bottom: 10px;">
            Back to users
        </a>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <form action="{{route('users.store')}}" method="POST">
            @csrf
            <x-inputs.text
                id="username"
                name="username"
                label="Username"
                type="text"
                placeholder="Username"
            />

            <x-inputs.text
                id="email"
                name="email"
                label="Email"
                type="email"
                placeholder="Email"
            />

            <x-inputs.text
                id="password"
                name="password"
                label="Password"
                type="password"
                placeholder="Password"
            />

            <x-inputs.text
                id="permissions"
                name="permissions"
                label="Permissions comma separated (permission1, permission2)"
                type="text"
                placeholder="permission1, permission2..."
                :description="$permissions"
            />

            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>
</x-layout>
