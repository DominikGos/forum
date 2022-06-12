<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>

<body class="d-flex flex-column justify-content-between vh-100">
    <nav class="main-navbar navbar navbar-expand-sm navbar-dark bg-dark p-2  position-fixed top-0 start-0 w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Forum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @if (Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('user.get', ['id' => Auth::id(), 'data-to-display' => 'threads']) }}"
                                class="nav-link">Profile</a>
                        </li>

                        @can('userList', App\Models\User\User::class)
                            <li class="nav-item">
                                <a href="{{ route('user.list') }}" class="nav-link">Users</a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="">

                                @csrf

                                <button type="submit" class="nav-link btn">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('register.form') }}" class="nav-link">Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login.form') }}" class="nav-link">Login</a>
                        </li>
                    @endif

                </ul>
                <form class="d-flex" method="GET" action="{{ route('topic.search') }}">
                    <input class="form-control me-2 btn-outline-light" name="name" type="search"
                        placeholder="Search topic by name." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="py-3 bg-white mt-3">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 Company, Inc</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
