<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand fs-2" href="#">
                Forum
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto gap-3">
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary fs-5">Register</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary fs-5">Login</button>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
