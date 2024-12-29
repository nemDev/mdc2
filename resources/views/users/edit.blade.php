<x-layout>
    <div class="d-flex justify-content-between align-items-center py-5">
        <h1 class="m-0">Edit User</h1>
        <a href="{{route('users.index')}}" class="btn btn-primary">
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
                id="permissions"
                name="permissions"
                label="Permissions comma separated (permission1, permission2)"
                type="text"
                :value="old('permissions', convertPermissionsToString($user->permissions()->pluck('name')->toArray()))"
                placeholder="permission1, permission2..."
                :description="$permissions"
            />

            <x-inputs.checkbox
                id="passwordChange"
                name="passwordChange"
                label="Change password"
                class="passwordChangeCheckbox"
                :checked="old('passwordChange')"
            />

            <div class="changePasswordWrapper">
                <x-inputs.text
                    id="password"
                    name="password"
                    label="New password"
                    type="password"
                    :value="old('password')"
                    placeholder="New password"
                />

                <x-inputs.text
                    id="password_confirmation"
                    name="password_confirmation"
                    label="Confirm new password"
                    type="password"
                    :value="old('password_confirmation')"
                    placeholder="Confirm new password"
                />
            </div>
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </form>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function (){
            const passwordCheckbox = document.getElementById('passwordChange');
            const changePasswordWrapper = document.querySelector('.changePasswordWrapper');
            changePasswordWrapper.style.display = 'none';
            if(passwordCheckbox.checked){
                changePasswordWrapper.style.display = 'block';
            }

            passwordCheckbox.addEventListener('change', function (){
                if(passwordCheckbox.checked){
                    changePasswordWrapper.style.display = 'block';
                }else{
                    changePasswordWrapper.style.display = 'none';
                }
            })
        });
    </script>
</x-layout>
