<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VAI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="#">VAI Appointment Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav">

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registration') }}">Register</a>
                    </li>

                @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>

                    </li>
                @if(session('user_type')==0)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.add')}}" >Add Users</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('users.list')}}">View Users</a></li>
                    @endif
                    @if(session('user_type')==0 || session('user_type')==2)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('appointment.make.form')}}">Book Appointments</a></li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>

                @endguest
            </ul>

        </div>
    </div>
</nav>
<div class="container mt-5">

    @yield('content')

</div>



</body>
</html>
