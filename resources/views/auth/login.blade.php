<x-layout>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h2 class="text-center font-bold">Login</h2>
            <form
                method="POST"
                action="{{route('login.authenticate')}}"
            >
                @csrf

                <x-inputs.text
                    id="username"
                    name="username"
                    label="Username"
                    type="text"
                    placeholder="Username"
                />

                <x-inputs.text
                    id="password"
                    name="password"
                    label="Password"
                    type="password"
                    placeholder="Password"
                />

                <button type="submit" class="btn btn-block btn-primary">Login</button>
            </form>
        </div>
    </div>
</x-layout>
