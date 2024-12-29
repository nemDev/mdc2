<header class="main-header">
    <a href="/" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <nav class="navbar p-0">
        @auth()
        <div class="w-100 px-4 d-flex justify-content-between align-items-center">
            <a href="#" class="sidebar-toggle hover:none" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="d-flex flex-row justify-content-end align-items-center gap-3">
                <a href="/" class="d-block text-white">Welcome, {{auth()->user()->username}} </a>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fa fa-sign-out"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </nav>
</header>
