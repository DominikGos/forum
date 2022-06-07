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
            <a class="navbar-brand fs-3" href="/">
                Forum
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto gap-3">

                    @if (Auth::check())

                        <li class="nav-item d-flex justify-content-end ">
                            <a href="{{ route('profile', ['id' => Auth::id(), 'data-to-display' => 'threads']) }}" class="btn btn-primary fs-5">Profile</a>
                        </li>
                        <form class="nav-item d-flex justify-content-end" method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button type="submit" class="btn btn-primary fs-5">Logout</button>
                        </form>

                    @else

                        <li class="nav-item d-flex justify-content-end ">
                            <a href="{{ route('register.form') }}" class="btn btn-primary fs-5">Register</a>
                        </li>
                        <li class="nav-item d-flex justify-content-end">
                            <a href="{{ route('login.form') }}" class="btn btn-primary fs-5">Login</a>
                        </li>

                    @endif

                </ul>
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
