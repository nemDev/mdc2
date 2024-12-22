<x-layout>
    <div class="d-flex justify-content-between">
        <h1 class="text-center d-inline">Edit User</h1>
        <a href="{{route('users.index')}}" class="btn btn-primary" style="margin-bottom: 10px;">
            Back to users
        </a>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <form action="{{route('users.update', $user->id)}}" method="POST">
            @csrf
            @method('PUT')
            <x-inputs.text
                id="username"
                name="username"
                label="Username"
                type="text"
                :value="old('title', $user->username)"
                placeholder="Username"
            />
            <x-inputs.text
                id="email"
                name="email"
                label="Email"
                type="email"
                :value="old('title', $user->email)"
                placeholder="Email"
            />

            <x-inputs.text
                id="password"
                name="password"
                label="Password"
                type="password"
                :value="old('title', $user->password)"
                placeholder="Password"
            />



            <x-inputs.text
                id="permissions"
                name="permissions"
                label="Permissions comma separated (permission1, permission2)"
                type="text"
                :value="old('permissions', convertPermissionsToString($user->permissions()->pluck('name')->toArray()))"
                placeholder="permission1, permission2..."
                :description="$permissions"
            />

            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>


</x-layout>
